<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Mesa;
use App\Models\AutoresCorrespondencia;
use App\Models\AsignaRevisores;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticlesMail;
use App\Mail\ArticulosEmail;
use App\Mail\ArticulosAceptadosEmail;
use App\Mail\ArticulosRechazadosEmail;
use App\Mail\ArticulosAceptadosCambiosEmail;
use App\Mail\PagosRegresados;
use App\Mail\PagosValidados;
use Illuminate\Support\Facades\Storage;

use ZipArchive;
use Illuminate\Support\Facades\File;
use App\Models\ComprobantePago;
use Illuminate\Support\Facades\Session;

class ContadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $estado_pago = null)
    {
        $texto = trim($request->get('texto'));

        // Inicializar la consulta
        $query = DB::table('articulos')
            ->join('comprobante_pagos', 'comprobante_pagos.id_articulo', '=', 'articulos.id_articulo')
            ->where('articulos.estado', 1);

        // Contar todos los pagos si no hay filtro
        $cantidadPagos = DB::table('comprobante_pagos')->count();

        if ($estado_pago !== null) {
            // Aplicar el filtro según el estado de pago
            if ($estado_pago == 2) {
                $query->where(function ($subQuery) {
                    $subQuery->where('comprobante_pagos.estado_pago', 2)
                        ->orWhereNull('comprobante_pagos.estado_pago');
                });
            } else {
                $query->where('comprobante_pagos.estado_pago', $estado_pago);
            }

            // Contar pagos según el estado filtrado
            $cantidadPagos = $query->count();
        }

        $Artic = $query->select('articulos.*')->get();

        // Obtener correos de autores
        $autores = DB::table('articulos')
            ->join('autores_correspondencias', 'autores_correspondencias.id_autor', '=', 'articulos.id_autor')
            ->select('articulos.id_articulo', 'autores_correspondencias.correo')
            ->get()
            ->keyBy('id_articulo');

        // Obtener pagos y sus URLs
        $pagos = DB::table('comprobante_pagos')
            ->select('id_articulo', 'comprobante', 'referencia', 'factura', 'constancia_fiscal', 'deleted_at', 'estado_pago', 'primera_factura', 'segunda_factura')
            ->get();

        $comprobanteUrls = [];
        foreach ($pagos as $pago) {
            $comprobanteUrls[$pago->id_articulo] = [
                'comprobante' => $pago->comprobante,
                'referencia' => $pago->referencia,
                'factura' => $pago->factura,
                'constancia_fiscal' => $pago->constancia_fiscal ? $pago->constancia_fiscal : null,
                'deleted_at' => $pago->deleted_at,
                'estado_pago' => $pago->estado_pago,
                'primera_factura' => $pago->primera_factura,
                'segunda_factura' => $pago->segunda_factura
            ];
        }

        $articulosConPagos = $pagos->pluck('id_articulo')->toArray();

        return view('contadores.index', compact('Artic', 'pagos', 'comprobanteUrls', 'articulosConPagos', 'autores', 'cantidadPagos', 'estado_pago'));
    }

    public function downloadComprobante($id_articulo)
    {
        $comprobante = ComprobantePago::findOrFail($id_articulo);

        $pathToFile = storage_path('app/public/' . $comprobante->comprobante);

        return response()->download($pathToFile);
    }

    public function downloadConstancia($id_articulo)
    {
        $constancia = ComprobantePago::findOrFail($id_articulo);

        $pathToFile = storage_path('app/public/' . $constancia->constancia_fiscal);

        return response()->download($pathToFile);
    }

    public function downloadFactura1($id_articulo)
    {
        $factura1 = ComprobantePago::findOrFail($id_articulo);

        $pathToFile = storage_path('app/public/' . $factura1->primera_factura);

        return response()->download($pathToFile);
    }

    public function downloadFactura2($id_articulo)
    {
        $factura1 = ComprobantePago::findOrFail($id_articulo);

        $pathToFile = storage_path('app/public/' . $factura1->segunda_factura);

        return response()->download($pathToFile);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function validarPago($id_articulo)
    {
        $comprobante = ComprobantePago::where('id_articulo', $id_articulo)->first();

        if ($comprobante) {
            $comprobante->estado_pago = 1; // Cambiar el estado de pago a 1
            $comprobante->save();

            // Obtener la información del artículo
            $articulo = Articulo::find($id_articulo);
            $autor = AutoresCorrespondencia::find($articulo->id_autor);

            // Enviar el correo al autor
            Mail::to($autor->correo)->send(new PagosValidados(
                $articulo->titulo,
                $articulo->revista,
                $articulo->modalidad
            ));

            Session::flash('success', 'Pago validado exitosamente.');
        } else {
            Session::flash('error', 'No se encontró el comprobante de pago.');
        }

        return redirect()->back();
    }


    public function regresarPago(Request $request, $id_articulo)
    {
        $request->validate([
            'observacion' => 'required|string|max:255',
        ],[
            'observacion.required' => 'Debe escribir al menos una observación que tenga el pago.',
            'observacion.max' => 'La observación no debe sobrepasar los 255 carácteres.'
        ]);

        $comprobante = ComprobantePago::where('id_articulo', $id_articulo)->first();

        if ($comprobante) {
            $comprobante->deleted_at = now(); // Marca el comprobante como eliminado
            $comprobante->observacion = $request->observacion; // Guarda la observación

            if ($comprobante->constancia_fiscal) {
                Storage::delete($comprobante->constancia_fiscal);
            }

            $comprobante->constancia_fiscal = null;
            //ESTADO 0 ES REGRESADO
            $comprobante->estado_pago = 0;
            $comprobante->save();

            // Obtener la información del artículo
            $articulo = Articulo::find($id_articulo);
            $autor = AutoresCorrespondencia::find($articulo->id_autor);

            // Enviar el correo al autor
            Mail::to($autor->correo)->send(new PagosRegresados(
                $articulo->titulo,
                $articulo->revista,
                $articulo->modalidad
            ));

            Session::flash('success', 'Pago regresado exitosamente.');
        } else {
            Session::flash('error', 'No se encontró el comprobante de pago.');
        }

        return redirect()->back();
    }
}

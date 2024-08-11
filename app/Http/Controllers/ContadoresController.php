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
    public function index(Request $request)
    {

        $texto = trim($request->get('texto'));

        // Si hay texto de búsqueda, se aplican los filtros
        if ($texto) {
            $Artic = DB::table('articulos')
                ->where('estado', 1)
                ->where(function ($query) use ($texto) {
                    $query->where('titulo', 'LIKE', '%' . $texto . '%')
                        ->orWhere('modalidad', 'LIKE', '%' . $texto . '%')
                        ->orWhere('revista', 'LIKE', '%' . $texto . '%');
                })
                ->get();
        } else {
            // Si no hay texto de búsqueda, solo se filtran los artículos por estado 1
            $Artic = DB::table('articulos')
                ->where('estado', 1)
                ->get();
        }

        // Obtener pagos y sus URLs
        $pagos = DB::table('comprobante_pagos')
            ->select('id_articulo', 'comprobante', 'referencia', 'factura', 'constancia_fiscal', 'deleted_at')
            ->get();

        $comprobanteUrls = [];
        foreach ($pagos as $pago) {
            $comprobanteUrls[$pago->id_articulo] = [
                'comprobante' => Storage::url($pago->comprobante),
                'referencia' => $pago->referencia,
                'factura' => $pago->factura,
                'constancia_fiscal' => $pago->constancia_fiscal ? Storage::url($pago->constancia_fiscal) : null,
                'deleted_at' => $pago->deleted_at
            ];
        }

        $articulosConPagos = $pagos->pluck('id_articulo')->toArray();

        return view('contadores.index', compact('Artic', 'pagos', 'comprobanteUrls', 'articulosConPagos'));
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComprobantePago;
use Illuminate\Support\Facades\Session;

class ComprobantePagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validación inicial
        $request->validate([
            'id_user' => 'required',
            'id_articulo' => 'required',
            'comprobante' => 'required|mimes:pdf|max:5120',
            'referencia' => 'required|string|max:255',
            'factura' => 'required|boolean',
            'constancia_fiscal' => 'nullable|mimes:pdf|max:5120',
        ], [
            'id_user.required' => 'El campo usuario es obligatorio.',
            'id_articulo.required' => 'El campo artículo es obligatorio.',
            'comprobante.required' => 'Debe subir un comprobante de pago.',
            'comprobante.mimes' => 'El comprobante de pago debe ser un archivo PDF.',
            'comprobante.max' => 'El tamaño máximo permitido para el comprobante de pago es 5MB.',
            'referencia.required' => 'Debe ingresar la referencia de pago.',
            'referencia.string' => 'La referencia debe ser texto.',
            'referencia.max' => 'La referencia no debe exceder los 255 caracteres.',
            'factura.required' => 'Debe seleccionar si requiere factura o no la requiere.',
            'factura.boolean' => 'El campo factura debe ser verdadero o falso.',
            'constancia_fiscal.mimes' => 'La constancia fiscal debe ser un archivo PDF.',
            'constancia_fiscal.max' => 'El tamaño máximo permitido para la constancia fiscal es 5MB.',
        ]);

        // Validación adicional para 'constancia_fiscal' si 'factura' es 1
        if ($request->factura == 1) {
            $request->validate([
                'constancia_fiscal' => 'required|mimes:pdf|max:20482',
            ], [
                'constancia_fiscal.required' => 'Debe subir la constancia de situación fiscal cuando selecciona "Sí" en factura.',
            ]);
        }

        // Buscar el comprobante existente
        $comprobante = ComprobantePago::where('id_articulo', $request->id_articulo)->first();

        if ($comprobante) {
            // Si el comprobante ya existe, actualiza los campos
            $comprobante->comprobante = $request->file('comprobante')->store('comprobantes', 'public');
            $comprobante->referencia = $request->referencia;
            $comprobante->factura = $request->factura;
            if ($request->factura == 1 && $request->hasFile('constancia_fiscal')) {
                $comprobante->constancia_fiscal = $request->file('constancia_fiscal')->store('constancias', 'public');
            }
            $comprobante->deleted_at = null; // Asegurarse de que el comprobante no esté marcado como eliminado
            $comprobante->save();
        } else {
            // Si el comprobante no existe, crea uno nuevo
            $comprobante = new ComprobantePago();
            $comprobante->id_user = $request->id_user;
            $comprobante->id_articulo = $request->id_articulo;
            $comprobante->comprobante = $request->file('comprobante')->store('comprobantes', 'public');
            $comprobante->referencia = $request->referencia;
            $comprobante->factura = $request->factura;
            if ($request->factura == 1 && $request->hasFile('constancia_fiscal')) {
                $comprobante->constancia_fiscal = $request->file('constancia_fiscal')->store('constancias', 'public');
            }
            $comprobante->save();
        }

        Session::flash('success', 'Se han enviado los comprobantes de pago');
        return redirect()->back();
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

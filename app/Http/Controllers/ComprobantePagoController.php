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
        //dd($request->all());
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
            $comprobante->estado_pago = 2; // Establece el estado de pago a 2 "PROCESO DE REVISIÓN"
            $comprobante->observacion = null;
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
            $comprobante->estado_pago = 2; // Establece el estado de pago a 2 "PROCESO DE REVISIÓN"
            $comprobante->save();
        }

        Session::flash('success', 'Se han enviado los comprobantes de pago');
        return redirect()->back();
    }

    public function updateFacturas(Request $request, $id_comprobante)
    {
        //dd($request->all());
        // Validar los archivos
        $request->validate([
            'primera_factura' => 'required|mimes:xml|max:2048',
            'segunda_factura' => 'required|mimes:pdf|max:2048',
        ]);

        // Buscar el registro existente en la tabla comprobante_pagos
        $comprobante = ComprobantePago::findOrFail($id_comprobante);

        // Procesar y guardar los archivos
        if ($request->hasFile('primera_factura') && $request->hasFile('segunda_factura')) {
            // Guardar la primera factura
            $primerInformePath = $request->file('primera_factura')->store('facturas', 'public');

            // Guardar la segunda factura
            $segundoInformePath = $request->file('segunda_factura')->store('facturas', 'public');

            // Actualizar los campos primera_factura y segunda_factura en el registro existente
            $comprobante->primera_factura = $primerInformePath;
            $comprobante->segunda_factura = $segundoInformePath;
            $comprobante->save();

            // Redireccionar con mensaje de éxito
            return redirect()->back()->with('success', 'Las facturas se han actualizado correctamente.');
        }

        // Manejar el caso de error
        return redirect()->back()->with('error', 'Hubo un problema al actualizar las facturas.');
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

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
        $request->validate([
            'id_user' => 'required|integer',
            'id_articulo' => 'required|integer',
            'comprobante' => 'required|mimes:pdf|max:2048',
            'referencia' => 'required|string|max:255',
            'factura' => 'required|boolean',
            'constancia_fiscal' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Lógica de almacenamiento
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

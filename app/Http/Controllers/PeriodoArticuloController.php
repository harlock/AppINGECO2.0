<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodoArticulo;

class PeriodoArticuloController extends Controller
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
        $periodos = PeriodoArticulo::all(); // Obtener todos los periodos de artículo
        return view('periodos.create', compact('periodos')); // Pasar $periodos a la vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after:fecha_inicio',
        ]);

        // Comprobar solapamiento de periodos
        $periodoSolapado = PeriodoArticulo::where(function ($query) use ($request) {
            $query->where('fecha_inicio', '<=', $request->fecha_fin)
                ->where('fecha_fin', '>=', $request->fecha_inicio);
        })->exists();

        if ($periodoSolapado) {
            return redirect()->route('periodos.create')
                ->with('error', 'Las fechas del periodo se solapan con un periodo existente.');
        }

        $periodo = new PeriodoArticulo;
        $periodo->fecha_inicio = $request->fecha_inicio;
        $periodo->fecha_fin = $request->fecha_fin;
        $periodo->save();

        return redirect()->route('periodos.create')
            ->with('success', 'Periodo de artículo creado exitosamente.');
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
        $periodo = PeriodoArticulo::findOrFail($id);
        return view('periodos.edit', compact('periodo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after:fecha_inicio',
        ]);

        // Comprobar solapamiento de periodos
        $periodoSolapado = PeriodoArticulo::where('id_periodo', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->where('fecha_inicio', '<=', $request->fecha_fin)
                    ->where('fecha_fin', '>=', $request->fecha_inicio);
            })->exists();

        if ($periodoSolapado) {
            return redirect()->route('periodos.edit', $id)
                ->with('error', 'Las fechas del periodo se solapan con un periodo existente.');
        }

        $periodo = PeriodoArticulo::findOrFail($id);
        $periodo->fecha_inicio = $request->fecha_inicio;
        $periodo->fecha_fin = $request->fecha_fin;
        $periodo->save();

        return redirect()->route('periodos.create')
            ->with('success', 'Periodo de artículo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periodo = PeriodoArticulo::findOrFail($id);
        $periodo->delete();

        return redirect()->route('periodos.create')
            ->with('success', 'Periodo de artículo eliminado exitosamente.');
    }
}
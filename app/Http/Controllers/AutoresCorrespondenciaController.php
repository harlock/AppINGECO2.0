<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AutoresCorrespondencia;

class AutoresCorrespondenciaController extends Controller
{
/*
    public function index()
    {
        $autores_correspondencias = AutoresCorrespondencia::all();
        return view('enviar_articulo.index', compact('autores_correspondencia'));
    }



    public function create()
    {
        return view('enviar_articulo.create');
    }



    public function store(Request $request)
    {
        $request->validate([
            'nom_autor' => 'required',
            'ap_autor' => 'required',
            'am_autor' => 'required',
            'correo' => 'required',
            'tel' => 'required',
        ]);

        AutoresCorrespondencia::create($request->all());
        return redirect()->route('enviar_articulo.index')->with('succes', 'articulo Registrada');
    }



    public function show(AutoresCorrespondencia $autor)
    {
        //
    }



    public function edit(AutoresCorrespondencia $autores_correspondencia)
    {
        return view('enviar_articulo.create');
    }



    public function update(Request $request, AutoresCorrespondencia $autores_correspondencia)
    {
        $request->validate([
            'nom_autor' => 'required',
            'ap_autor' => 'required',
            'am_autor' => 'required',
            'correo' => 'required',
            'tel' => 'required',
        ]);


        $autores_correspondencia->update($request->all());
        return redirect()->route('enviar_articulo.index')->with('succes', 'articulo Actualizado');
    
    }



    public function destroy(AutoresCorrespondencia $autores_correspondencia)
    {
        $autores_correspondencia->delete();
        return redirect()->route('enviar_articulo.index')->with('succes', 'articulo eliminado definitivamente');
    }*/
}

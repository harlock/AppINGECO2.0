<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\ArchivosDerechos;
use App\Models\Articulo;


class ArchivosDerechosController extends Controller
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
        // Validar la solicitud
        $request->validate([
            'id_articulo' => 'required|exists:articulos,id_articulo',
            'archivo_derecho' => 'required|mimes:pdf|max:5120', // 5MB máximo
        ], [
            'id_articulo.required' => 'El campo artículo es obligatorio.',
            'id_articulo.exists' => 'El artículo seleccionado no existe.',
            'archivo_derecho.required' => 'Debe subir un archivo PDF.',
            'archivo_derecho.mimes' => 'El archivo debe ser un PDF.',
            'archivo_derecho.max' => 'El tamaño máximo permitido para el archivo es de 5MB.',
        ]);

        // Buscar el archivo existente para el artículo
        $archivoDerecho = ArchivosDerechos::where('id_articulo', $request->id_articulo)->first();

        if ($archivoDerecho) {
            // Si el archivo ya existe, actualizarlo
            $archivoDerecho->archivo_derecho = $request->file('archivo_derecho')->store('archivos_derechos', 'public');
        } else {
            // Si el archivo no existe, crear uno nuevo
            $archivoDerecho = new ArchivosDerechos();
            $archivoDerecho->id_articulo = $request->id_articulo;
            $archivoDerecho->archivo_derecho = $request->file('archivo_derecho')->store('archivos_derechos', 'public');
        }

        // Guardar el registro en la base de datos
        $archivoDerecho->save();

        // Mensaje de éxito
        return redirect()->back()->with('success', 'El archivo ha sido subido exitosamente');
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
        $request->validate([
            'estado' => 'required|in:1,2',
            'mensaje' => 'nullable|string',
        ]);

        $archivoDerecho = ArchivosDerechos::where('id_articulo', $id)->first();

        if ($archivoDerecho) {
            $archivoDerecho->estado = $request->input('estado');
            $archivoDerecho->mensaje = $request->input('mensaje', $archivoDerecho->mensaje);
            $archivoDerecho->save();

            return redirect()->back()->with('success', 'Archivo de derechos actualizado con éxito.');
        }

        return redirect()->back()->with('error', 'Archivo de derechos no encontrado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

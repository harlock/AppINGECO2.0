@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <div class="alert alert-success d-flex justify-content-between" role="alert">
            Envio de Artículos
            <a class="btn btn-primary" href="{{url('enviar_articulo/create')}}"><i class="bi bi-file-earmark-plus-fill"></i> Envio de Artículos</a>
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>Session</p>
</div>
@endif



<div class="row justify-content-center mt-4">
    <div class="col-10">

        <div class="mt-10 mt-lg-5 mb-6 d-flex align-items-center d-lg-block">
            <span class="d-inline-block d-lg-block h1 mb-lg-6 me-3"></span>
            <h1 class="ls-tight font-bolder h2 text-center">
                {{ __('¡Artículos!') }}
            </h1>
        </div>
        <div>
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-300">
                        <th class="px-4 py-2">Titulo </th>
                        <th class="px-4 py-2">Estado </th>
                        <th class="px-4 py-2">Archivo </th>
                        <th class="px-4 py-2">Mesa </th>
                        <th class="px-4 py-2">Autor </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articulos as $articulo)
                    <tr>
                        <td class="border px-4 py-2">{{ $articulo->titulo }}</td>
                        <td class="border px-4 py-2">{{ $articulo->estado}}</td>
                        <td class="border px-4 py-2">{{ $articulo->archivo }}</td>
                        <td class="border px-4 py-2">{{ $articulo->id_mesa}}</td>
                        <td class="border px-4 py-2">{{ $articulo->id_autor}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10 mt-lg-5 mb-6 d-flex align-items-center d-lg-block">
            <span class="d-inline-block d-lg-block h1 mb-lg-6 me-3"></span>
            <h1 class="ls-tight font-bolder h2 text-center">
                {{ __('¡Autores!') }}
            </h1>
        </div>


        <div class="mt-8">
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-300">
                        <th class="px-4 py-2">nombre </th>
                        <th class="px-4 py-2">apellido paterno </th>
                        <th class="px-4 py-2">apellido materno </th>
                        <th class="px-4 py-2">correo </th>
                        <th class="px-4 py-2">telefono </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($autores_correspondencias as $autor)
                    <tr>
                        <td class="border px-4 py-2">{{ $autor->nom_autor }}</td>
                        <td class="border px-4 py-2">{{ $autor->ap_autor}}</td>
                        <td class="border px-4 py-2">{{ $autor->am_autor }}</td>
                        <td class="border px-4 py-2">{{ $autor->correo}}</td>
                        <td class="border px-4 py-2">{{ $autor->tel}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="mt-10 mt-lg-5 mb-6 d-flex align-items-center d-lg-block">
            <span class="d-inline-block d-lg-block h1 mb-lg-6 me-3"></span>
            <h1 class="ls-tight font-bolder h2 text-center">
                {{ __('¡Mesas!') }}
            </h1>
        </div>

        <div class="mt-8">
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-300">
                        <th class="px-4 py-2">nombre de la mesa </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mesas as $mesa)
                    <tr>
                        <td class="border px-4 py-2">{{ $mesa->descripcion }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>


@endsection
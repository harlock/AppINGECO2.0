@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-10">
        <div class="col">
            <h3 class=" justify-content-center alert bg-blue-800 d-flex  text-white">
                Artículos enviados
            </h3>
        </div>
        <br>

        <div class=" table-responsive-xl bg-white border rounded-lg mt-4 p-3 shadow-sm tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="table">
                <thead>
                    <tr>
                        <th class=" text-center">Estado</th>
                        <th class=" text-center">Revista</th>
                        <th class=" text-center">Nombre del artículo</th>
                        <th class=" text-center">Modalidad</th>
                        <th class=" text-center">Archivo</th>
                        <th class=" text-center">Mesa asignada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $articulo)
                    <tr class="{{ $articulo->estado == 0 ? "bg-gray-100" : ($articulo->estado == 1 ? "bg-green-100" : ($articulo->estado == 2 ? "bg-red-100" : "bg-yellow-100")) }}">
                        <td class="">
                            @if($articulo->estado == 0)
                            <i class="bi bi-bookmark-dash-fill"></i> Sin revisar 
                            @elseif($articulo->estado == 1)
                            <i class="bi bi-bookmark-check-fill"></i> Aceptado
                            @elseif($articulo->estado == 2)
                            <i class="bi bi-bookmark-x-fill"></i> Rechazado
                            @else
                            <i class="bi bi-bookmark-dash-fill"></i> En proceso de revisión
                            @endif
                        </td>
                        <td>{{$articulo->revista }}</td>
                        <td class="text-wrap text-break">{{$articulo->titulo }}</td>
                        <td>{{$articulo->modalidad }}</td>
                        <td class="font-semibold ">
                            <a class="btn btn-primary" href="{{route('art.download',$articulo->titulo)}}">Descargar <i class="bi bi-arrow-down-square-fill"></i></a>
                        </td>
                        <td class="text-wrap text-break">{{$articulo->descripcion }}</td>
                        <td>
                            {{---
                            <a>
                                <a href="{{route('art.destroy',$articulo->id_articulo)}}" class=" btn btn-danger">
                                    Eliminar
                                </a>
                            </a>
                            --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
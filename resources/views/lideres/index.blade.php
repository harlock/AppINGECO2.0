@extends('layouts.app')

@section('content')

    <div class="row mx-20">
        <div class="col bg-blue-800 rounded-lg justify-content-center">
            <h3 class="justify-content-center alert d-flex text-white">
                Asignación de revisores
            </h3>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-10">
            <div class="card">
                <div class="row">
                    <div class="col-6">
                        <div class="card-body">
                            <h5 class="card-title alert alert-primary">Lista de revisores</h5>
                            <ul class="list-group">
                                @foreach($usuarios as $usuario)
                                    <li class="list-group-item">
                                        {{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}
                                        <button type="button" class="btn btn-outline-info float-end" data-bs-toggle="modal" data-bs-target="#modal{{$usuario->id}}">
                                            <i class="bi bi-plus-square-fill"></i> Asignar artículo
                                        </button>
                                        @include("lideres.modal_asigna_autor")
                                        <!--
                                <button type="button" class="btn btn-outline-danger float-end" data-bs-toggle="modal" data-bs-target="#modaldeleteRevisor{{$usuario->id}}">
                                    <i class="bi bi-trash-fill"></i> Eliminar de los revisores
                                </button>
                                -->
                                        @include("lideres.modal_delete_revisor")
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-body">
                            <h5 class="card-title alert alert-primary">Revisores asignados</h5>
                            <ul class="list-group">
                                @foreach($lista_revisores->groupBy('nombreRevisores') as $nombreRevisor => $articulos)
                                    <li class="list-group-item">
                                        <h4>
                                            <span style="color: #313278; font-size: 1.3rem;">Revisor: </span>
                                            <span style="color: #5356dd; font-size: 1.3rem;">{{ $nombreRevisor }}</span>
                                        </h4>
                                        <ul class="list-group mt-2">
                                            @foreach($articulos as $revisor)
                                                <li class="list-group-item" style="background: #f6f6f6">
                                                    <div>{{ $revisor->titulo }}</div>
                                                    <button type="button" class="btn btn-outline-danger mt-2" data-bs-toggle="modal" data-bs-target="#modaldelete{{$revisor->id}}">
                                                        <i class="bi bi-trash-fill"></i> Eliminar del artículo
                                                    </button>
                                                </li>
                                                @include("lideres.modal_delete_revisor_articulo", ['revisor' => $revisor])
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

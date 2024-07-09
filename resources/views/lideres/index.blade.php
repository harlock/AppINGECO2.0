@extends('layouts.app')

@section('content')

<div class="row mx-20">
    <div class="col bg-blue-800 rounded-lg justify-content-center">
        <h3 class=" justify-content-center alert  d-flex text-white ">
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
                        <h5 class="card-title alert alert-primary">Lista de revisores </h5>
                        <ul class="list-group">
                            @foreach($usuarios as $usuario)
                            <li class="list-group-item ">{{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}
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
                            @foreach($lista_revisores as $revisor)
                            <li class="list-group-item">
                                <h4>Revisor:</h4>
                                {{$revisor->nombreRevisores }}
                                <h4>Asignado al artículo:</h4>
                                {{$revisor->titulo}}
                                <span class="badge bg-warning text-dark"></span>
                                <button type="button" class="btn btn-outline-danger float-end" data-bs-toggle="modal" data-bs-target="#modaldelete{{$revisor->id}}">
                                    <i class="bi bi-trash-fill"></i> Eliminar del artículo
                                </button>
                            </li>
                            @include("lideres.modal_delete_revisor_articulo")
                            @endforeach
                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
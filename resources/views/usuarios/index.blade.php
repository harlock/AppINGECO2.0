@extends('layouts.app')

@section('content')
<div class="row mx-20">
    <div class="col bg-blue-800 rounded-lg justify-content-center">
        <h3 class=" justify-content-center alert  d-flex text-white ">
            Asignación de líder a una mesa
        </h3>
    </div>
</div>

<div class="row justify-content-center mt-4 ">
    <div class="col-10">
        <div class="card ">
            <div class="row">
                <div class="col-6">
                    <div class="card-body ">
                        <h5 class="card-title alert alert-primary">Líderes sin asignar </h5>
                        <ul class="list-group">
                            @foreach($usuariosRegistrados as $usuario)
                            <div class="p-2">
                                <li class="list-group-item ">
                                    <div>
                                        {{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-danger " data-bs-toggle="modal" data-bs-target="#modaldeleteRevisor{{$usuario->id}}">
                                            <i class="bi bi-trash-fill"></i> Eliminar de los líderes
                                        </button>
                                        @include("usuarios.modal_delete_revisor")
                                        <button type="button" class="btn btn-outline-info " data-bs-toggle="modal" data-bs-target="#modal{{$usuario->id}}">
                                            <i class="bi bi-plus-square-fill"></i>
                                        </button>
                                        @include("usuarios.modal_mesa")
                                    </div>
                                </li>

                            </div>

                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-body">
                        <h5 class="card-title alert alert-primary">Líderes asignados</h5>
                        <ul class="list-group">
                            @foreach($usuariosAsignados as $usuario)
                            <li class="list-group-item">{{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}} <span class="badge bg-warning text-dark">{{$usuario->descripcion}}</span>
                                <button type="button" class="btn btn-outline-danger float-end" data-bs-toggle="modal" data-bs-target="#modaldelete{{$usuario->id}}">
                                    <i class="bi bi-trash-fill"></i> Eliminar de la mesa
                                </button>
                            </li>
                            @include("usuarios.modal_delete_mesa")
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
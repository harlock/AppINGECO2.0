@extends('layouts.app')

@section('content')
<div class="row mx-20">
    <div class="col bg-blue-800 rounded-lg">
        <h3 class=" justify-content-center alert  d-flex text-white ">
            Asignación de revisores a mesas
        </h3>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-10">
        <div class="card">
            <div class="row">
                <div class="col-6">

                    <div class="card-body">

                        <h5 class="card-title alert alert-primary">Revisores sin asignar</h5>
                        <ul class="list-group">
                            @foreach($usuariosRegistrados as $usuario)
                            <li class="list-group-item ">{{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}
                                <button type="button" class="btn btn-outline-info float-end" data-bs-toggle="modal" data-bs-target="#modal{{$usuario->id}}"><i class="bi bi-plus-square-fill"></i></button>
                                @include("revisores.modal_mesa")

                                <button type="button" class="btn btn-outline-danger float-end" data-bs-toggle="modal" data-bs-target="#modaldeleteRevisor{{$usuario->id}}">
                                    <i class="bi bi-trash-fill"></i> Eliminar de los revisores
                                </button>

                                @include("revisores.modal_delete_revisor")

                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-body">
                        <h5 class="card-title alert alert-primary">Revisores asignados</h5>
                        <ul class="list-group">
                            @foreach($usuariosAsignados as $usuario)
                            <li class="list-group-item">{{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}} <span class="badge bg-warning text-dark">{{$usuario->descripcion}}</span>
                                <button type="button" class="btn btn-outline-danger float-end" data-bs-toggle="modal" data-bs-target="#modaldelete{{$usuario->id}}">
                                    <i class="bi bi-trash-fill"></i> Eliminar de la mesa
                                </button>
                            </li>
                            @include("revisores.modal_delete_mesa")
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push("scripts")
<script type="text/javascript">
    //  new bootstrap.Modal(document.getElementById('modal2'));
</script>
@endpush
@endsection
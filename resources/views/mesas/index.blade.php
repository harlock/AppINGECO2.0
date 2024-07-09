@extends('layouts.app')

@section('content')

<div class="row mx-20">
    <div class="col bg-blue-800 rounded-lg">
        <div class="  d-flex justify-content-between">
            <h3 class=" justify-content-center alert  d-flex text-white ">
                Mesas
            </h3>
            <div class="p-2">
                <a class="btn btn-primary" href="{{url('mesas/create')}}"><i class="bi bi-file-earmark-plus-fill"></i> Agregar una mesa</a>
            </div>
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
        @foreach($Mesas as $mesa)
        <div class="card container py-5 border my-3">
            Descripción
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h3 class="w-full">{{$mesa->descripcion}}</h3>
                    <div class="d-flex justify-content-between">
                        {{--Acciones como eliminar y editar--}}
                        <a class="btn btn-primary mx-2" href="{{url("mesas",$mesa->id_mesa)."/edit"}}">
                            EDITAR
                        </a>
                        {{--
                                    <form action="{{url("mesas",$mesa->id_mesa)}}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-danger">ELIMINAR</button>
                        </form>
                        --}}

                        <ul class="list-group">
                            <button type="button" class="btn btn-outline-danger float-end" data-bs-toggle="modal" data-bs-target="#modaldele{{$mesa->id_mesa}}">ELIMINAR</button>
                            @include("mesas.modal_delete_mesa")
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2 style="color: #00b4d9; text-align: center">CREAR NUEVA MESA</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{url('mesas')}}" title="Atras"><i class="bi bi-arrow-left-circle"></i>Volver </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{url('mesas')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"><h2>Descripción de la mesa</h2></label>
                <input type="text" name="descripcion" class="form-control" placeholder="Escriba la descripción de la mesa asignada">
                <div id="emailHelp" class="form-text">Describa cuidadosamente los detalles de la mesa</div>
            </div>
            <div class="d-flex  justify-content-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
@endsection

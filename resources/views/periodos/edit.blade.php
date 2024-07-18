@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Editar Periodo de Artículo</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('periodos.update', $periodo->id_periodo) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 row">
                        <label for="fecha_inicio" class="col-sm-3 col-form-label text-end">Fecha de Inicio</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required value="{{ $periodo->fecha_inicio }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fecha_fin" class="col-sm-3 col-form-label text-end">Fecha de Fin</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required value="{{ $periodo->fecha_fin }}">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

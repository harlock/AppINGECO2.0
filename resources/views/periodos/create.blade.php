@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Crear Periodo de Artículo</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('periodos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="fecha_inicio" class="col-sm-3 col-form-label text-end">Fecha de Inicio</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fecha_fin" class="col-sm-3 col-form-label text-end">Fecha de Fin</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>

                <hr>

                <h2 class="text-center mb-4">Periodos de Artículos Registrados</h2>
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($periodos as $periodo)
                        <tr>
                            <td>{{ $periodo->fecha_inicio }}</td>
                            <td>{{ $periodo->fecha_fin }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

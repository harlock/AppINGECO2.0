@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Crear Periodo de Artículo</h1>

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

                <form action="{{ route('periodos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label for="fecha_inicio" class="col-sm-3 col-form-label text-end">Fecha de Inicio</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required value="{{ old('fecha_inicio') }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fecha_fin" class="col-sm-3 col-form-label text-end">Fecha de Fin</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required value="{{ old('fecha_fin') }}">
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
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($periodos as $periodo)
                        <tr>
                            <td>{{ $periodo->fecha_inicio }}</td>
                            <td>{{ $periodo->fecha_fin }}</td>
                            <td>
                                <a href="{{ route('periodos.edit', $periodo->id_periodo) }}" class="btn btn-warning btn-sm">Editar</a>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $periodo->id_periodo }})">Eliminar</button>
                                <form id="delete-form-{{ $periodo->id_periodo }}" action="{{ route('periodos.destroy', $periodo->id_periodo) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('¿Está seguro de que desea eliminar este periodo?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endsection

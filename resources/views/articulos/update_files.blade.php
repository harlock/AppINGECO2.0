@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Actualizar Archivos de Artículos</h1>
        <p class="lead">Aquí puedes actualizar el archivo del artículo (Word) o el archivo antiplagio (PDF) de tus artículos en estado "Sin revisar". Solo sube el archivo que deseas cambiar.</p>

        <!-- Mostrar alerta de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($Artic->isEmpty())
            <div class="alert alert-info">
                No tienes artículos en estado "Sin revisar" para actualizar.
            </div>
        @else
            <div class="row">
                @foreach($Artic as $articulo)
                    <div class="col-md-6">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">{{ $articulo->titulo }}</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Estado:</strong> Sin revisar</p>

                                <!-- Archivo Artículo Actual -->
                                <div class="mb-3">
                                    <strong>Archivo Artículo Actual:</strong>
                                    @if($articulo->archivo)
                                        <a href="{{ route('art.download', $articulo->titulo) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="bi bi-download"></i> Descargar (.doc/.docx)
                                        </a>
                                    @else
                                        <span class="text-muted">No subido</span>
                                    @endif
                                </div>

                                <!-- Archivo Antiplagio Actual -->
                                <div class="mb-3">
                                    <strong>Archivo Antiplagio Actual:</strong>
                                    @if($articulo->archivo_plagio)
                                        <a href="{{ route('art.downloadPlagio', $articulo->titulo) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="bi bi-download"></i> Descargar (PDF)
                                        </a>
                                    @else
                                        <span class="text-muted">No subido</span>
                                    @endif
                                </div>

                                <!-- Formulario para actualizar -->
                                <form action="{{ route('enviar_articulo.updateFiles', $articulo->id_articulo) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="articulo_{{ $articulo->id_articulo }}" class="form-label">
                                            <strong>Nuevo Archivo Artículo</strong> (Word .doc/.docx, máx. 5MB)
                                        </label>
                                        <input type="file" name="articulo" id="articulo_{{ $articulo->id_articulo }}" class="form-control" accept=".doc,.docx">
                                        @error('articulo')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="antiplagio_{{ $articulo->id_articulo }}" class="form-label">
                                            <strong>Nuevo Archivo Antiplagio</strong> (PDF, máx. 5MB)
                                        </label>
                                        <input type="file" name="antiplagio" id="antiplagio_{{ $articulo->id_articulo }}" class="form-control" accept=".pdf">
                                        @error('antiplagio')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-upload"></i> Actualizar Archivos Seleccionados
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <!-- Asegúrate de que Bootstrap JS esté incluido para las alertas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
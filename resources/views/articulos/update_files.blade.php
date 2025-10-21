@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Actualizar Archivos de Artículos</h1>
        <div class="p-3 mb-3 bg-secondary bg-opacity-10 border-start border-5 border-secondary rounded">
            <p class="lead mb-0">
                <strong>Artículos "Sin revisar":</strong> Puedes actualizar <strong>el archivo del artículo</strong> y <strong>el archivo antiplagio</strong>.
            </p>
        </div>

        <div class="p-3 mb-3 bg-primary bg-opacity-10 border-start border-5 border-primary rounded">
            <p class="lead mb-0 text-dark">
                <strong>Artículos "En proceso de revisión"</strong> o <strong>"Aceptados condicionados":</strong> Solo puedes actualizar <strong>el archivo antiplagio</strong>.
            </p>
        </div>

        <div class="p-3 mb-3 bg-warning bg-opacity-10 border-start border-5 border-warning rounded">
            <p class="lead mb-0">
                Esto último debe hacerse únicamente si tu revisor lo solicita.
                No actualices el archivo antiplagio si no es necesario.
                Para actualizar tu archivo de artículo, usa la sección <strong>"Artículos Enviados"</strong>.
            </p>
        </div>


        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($Artic->isEmpty())
            <div class="alert alert-info">
                No tienes artículos disponibles para actualizar según su estado actual.
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
                                <p><strong>Estado:</strong>
                                    @if($articulo->estado == 0)
                                        Sin revisar
                                    @elseif($articulo->estado == 4)
                                        Revisión líder
                                    @elseif($articulo->estado == 5)
                                        Aceptado condicionado
                                    @else
                                        Otro
                                    @endif
                                </p>

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
                                @if(in_array($articulo->estado, [0, 4, 5]))
                                    <form action="{{ route('enviar_articulo.updateFiles', $articulo->id_articulo) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        @if($articulo->estado == 0)
                                            <!-- Solo estado 0 puede actualizar el artículo -->
                                            <div class="mb-3">
                                                <label for="articulo_{{ $articulo->id_articulo }}" class="form-label">
                                                    <strong>Nuevo Archivo Artículo</strong> (Word .doc/.docx, máx. 5MB)
                                                </label>
                                                <input type="file" name="articulo" id="articulo_{{ $articulo->id_articulo }}" class="form-control" accept=".doc,.docx">
                                                @error('articulo')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif

                                        <!-- Todos los estados permiten actualizar antiplagio -->
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
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

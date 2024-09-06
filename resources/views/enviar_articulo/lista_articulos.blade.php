@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div class="row justify-content-center mt-4">
        <div class="col-12">

            <h3 class="justify-content-center alert bg-blue-800 d-flex text-white mb-5">
                Artículos enviados
            </h3>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive bg-white border rounded-lg mt-4 p-3 shadow-sm tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Revista</th>
                        <th class="text-center">Nombre del Artículo</th>
                        <th class="text-center">Modalidad</th>
                        <th class="text-center">Archivos Descargables</th>
                        <th class="text-center">Mesa Asignada</th>
                        <th class="text-center">Carta de Cesión de Derechos</th>
                        <th class="text-center">Comprobante de Pago</th>
                        <th class="text-center">Observación de Pagos</th>
                        <th class="text-center">Envio de Artículo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($articulos as $articulo)
                        <tr class="{{ $articulo->estado == 0 ? 'bg-gray-100' : ($articulo->estado == 1 ? 'bg-green-100' : ($articulo->estado == 2 ? 'bg-red-100' : ($articulo->estado == 5 ? 'bg-blue-100' : 'bg-yellow-100'))) }}">
                            <td class="text-center">
                                @if($articulo->estado == 0)
                                    <i class="bi bi-bookmark-dash-fill"></i> Sin revisar
                                @elseif($articulo->estado == 1)
                                    <i class="bi bi-bookmark-check-fill"></i> Aceptado
                                @elseif($articulo->estado == 2)
                                    <i class="bi bi-bookmark-x-fill"></i> Rechazado
                                @elseif($articulo->estado == 5)
                                    <i class="bi bi-bookmark-star-fill"></i> Aceptado condicionado
                                @else
                                    <i class="bi bi-bookmark-dash-fill"></i> En proceso de revisión
                                @endif
                            </td>
                            <td class="text-center">{{ $articulo->revista }}</td>
                            <td class="text-wrap text-break">{{ $articulo->titulo }}</td>
                            <td class="text-center">{{ $articulo->modalidad }}</td>
                            <td class="text-center">
                                <a class="btn btn-primary  d-block mb-2" href="{{ route('art.download', $articulo->titulo) }}">
                                    <i class="bi bi-file-earmark-text-fill"></i> Artículo
                                </a>

                                <a class="btn btn-primary  d-block mb-2" href="{{ route('art.downloadPlagio', $articulo->titulo) }}">
                                    <i class="bi bi-shield-lock-fill"></i> Antiplagio
                                </a>

                                @if(!empty($articulo->carta_aceptacion))
                                    <a class="btn btn-primary d-block" href="{{ route('art.downloadCarta', $articulo->titulo) }}">
                                        <i class="bi bi-file-earmark-check-fill"></i> Carta Aceptación
                                    </a>
                                @endif
                            </td>
                            <td class="text-wrap text-break">{{ $articulo->descripcion }}</td>
                            <td class="text-center">
                                @if($articulo->estado == 1)
                                    @php
                                        $archivoDerecho = App\Models\ArchivosDerechos::where('id_articulo', $articulo->id_articulo)->first();
                                    @endphp

                                    @if($archivoDerecho)
                                        @if($archivoDerecho->estado == 1)
                                            <!-- Si el archivo de derechos está aceptado -->
                                            <button type="button" class="btn btn-success mb-2" disabled>
                                                Carta de Derechos Aceptada
                                            </button>
                                        @elseif($archivoDerecho->estado == 2)
                                            <!-- Si el archivo de derechos fue rechazado -->
                                            <button type="button" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#reenviarDerechoModal{{ $articulo->id_articulo }}">
                                                Reenviar Carta de Derechos
                                            </button>
                                        @else
                                            <!-- Si el archivo de derechos está en revisión o pendiente -->
                                            <button type="button" class="btn btn-secondary mb-2" disabled>
                                                Carta en Revisión
                                            </button>
                                        @endif
                                    @else
                                        <!-- Si no hay archivo de derechos -->
                                        <button type="button" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#uploadDerechoModal{{ $articulo->id_articulo }}">
                                            Subir Carta de Derechos
                                        </button>
                                    @endif

                                    <!-- Modal para "Subir Archivo Derecho" -->
                                    <div class="modal fade" id="uploadDerechoModal{{ $articulo->id_articulo }}" tabindex="-1" aria-labelledby="uploadDerechoModalLabel{{ $articulo->id_articulo }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadDerechoModalLabel{{ $articulo->id_articulo }}">Subir Carta de Cesión de Derecho</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('archivos_derechos.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_articulo" value="{{ $articulo->id_articulo }}">
                                                        <div class="mb-3">
                                                            <label for="archivo_derecho" class="form-label">Archivo Derecho (PDF)</label>
                                                            <input type="file" class="form-control @error('archivo_derecho') is-invalid @enderror" id="archivo_derecho" name="archivo_derecho" accept="application/pdf">
                                                            @error('archivo_derecho')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                            <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal para "Reenviar Archivo Derecho" si fue rechazado -->
                                    <div class="modal fade" id="reenviarDerechoModal{{ $articulo->id_articulo }}" tabindex="-1" aria-labelledby="reenviarDerechoModalLabel{{ $articulo->id_articulo }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reenviarDerechoModalLabel{{ $articulo->id_articulo }}">Reenviar Archivo Derecho</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('archivos_derechos.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_articulo" value="{{ $articulo->id_articulo }}">
                                                        <div class="mb-3">
                                                            <label for="archivo_derecho" class="form-label">Archivo Derecho (PDF)</label>
                                                            <input type="file" class="form-control @error('archivo_derecho') is-invalid @enderror" id="archivo_derecho" name="archivo_derecho" accept="application/pdf">
                                                            @error('archivo_derecho')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                            <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Mensaje de Rechazo</label>
                                                            <textarea class="form-control" readonly>{{ $archivoDerecho->mensaje ?? 'No hay mensaje.' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Reenviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $comprobanteExistente = App\Models\ComprobantePago::where('id_articulo', $articulo->id_articulo)->first();
                                    $archivoDerechoAceptado = App\Models\ArchivosDerechos::where('id_articulo', $articulo->id_articulo)
                                                                                        ->where('estado', 1)
                                                                                        ->exists();
                                @endphp

                                @if($articulo->estado == 1)
                                    @if($archivoDerechoAceptado)
                                        @if($comprobanteExistente && $comprobanteExistente->estado_pago == 0)
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#comprobanteModal-{{ $articulo->id_articulo }}">
                                                Agregar nuevo comprobante
                                            </button>
                                        @elseif(!$comprobanteExistente)
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#comprobanteModal-{{ $articulo->id_articulo }}">
                                                Agregar comprobante
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success" disabled>
                                                Comprobante enviado
                                            </button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-secondary" disabled>
                                            Agregar comprobante
                                        </button>
                                    @endif
                                @endif

                                <!-- Modal -->
                                <div class="modal fade" id="comprobanteModal-{{ $articulo->id_articulo }}" tabindex="-1" aria-labelledby="comprobanteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="comprobanteModalLabel">Agregar Comprobante de Pago</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="{{ route('comprobantes.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_articulo" value="{{ $articulo->id_articulo }}">
                                                    <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">

                                                    <div class="mb-3">
                                                        <label for="comprobante" class="form-label">Comprobante de pago (PDF)</label>
                                                        <input type="file" class="form-control @error('comprobante') is-invalid @enderror" id="comprobante" name="comprobante" accept="application/pdf">
                                                        @error('comprobante')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                        <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="referencia" class="form-label">Referencia</label>
                                                        <input type="text" class="form-control @error('referencia') is-invalid @enderror" id="referencia" name="referencia" value="{{ old('referencia') }}">
                                                        @error('referencia')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">¿Requiere factura?</label>
                                                        <div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input @error('factura') is-invalid @enderror" type="radio" name="factura" id="factura_si_{{ $articulo->id_articulo }}" value="1" {{ old('factura') == '1' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="factura_si_{{ $articulo->id_articulo }}">Sí</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input @error('factura') is-invalid @enderror" type="radio" name="factura" id="factura_no_{{ $articulo->id_articulo }}" value="0" {{ old('factura') == '0' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="factura_no_{{ $articulo->id_articulo }}">No</label>
                                                            </div>
                                                        </div>
                                                        @error('factura')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3" id="constancia_fiscal_group_{{ $articulo->id_articulo }}" style="{{ old('factura') == '1' ? 'display: block;' : 'display: none;' }}">
                                                        <label for="constancia_fiscal_{{ $articulo->id_articulo }}" class="form-label">Constancia de situación fiscal (PDF)</label>
                                                        <input type="file" class="form-control @error('constancia_fiscal') is-invalid @enderror" id="constancia_fiscal_{{ $articulo->id_articulo }}" name="constancia_fiscal" accept="application/pdf">
                                                        @error('constancia_fiscal')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                        <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.querySelectorAll('.modal').forEach((modal) => {
                                            const articuloId = modal.id.split('-').pop(); // Extrae el ID del artículo desde el ID del modal
                                            const facturaRadioButtons = modal.querySelectorAll('input[name="factura"]'); // Selecciona todos los radio buttons del modal actual
                                            const constanciaFiscalGroup = document.getElementById(`constancia_fiscal_group_${articuloId}`);

                                            // Función para manejar el cambio en los radio buttons
                                            const handleFacturaChange = function(event) {
                                                if (event.target.value === '1') {
                                                    constanciaFiscalGroup.style.display = 'block'; // Muestra el campo si selecciona 'Sí'
                                                } else {
                                                    constanciaFiscalGroup.style.display = 'none'; // Oculta el campo si selecciona 'No'
                                                }
                                            };

                                            // Asigna la función a cada radio button
                                            facturaRadioButtons.forEach((elem) => {
                                                elem.addEventListener('change', handleFacturaChange);
                                            });

                                            // Inicializa la visibilidad del campo cuando se carga el modal
                                            const initialCheckedRadio = modal.querySelector('input[name="factura"]:checked');
                                            if (initialCheckedRadio) {
                                                handleFacturaChange({ target: initialCheckedRadio });
                                            }
                                        });
                                    });
                                </script>

                            </td>
                            <td class="text-center">
                                @if($articulo->observacion)
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#observacionesModal-{{ $articulo->id_articulo }}" title="Ver Observaciones">
                                        Observación en pagos <i class="fa fa-comments"></i>
                                    </button>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($articulo->estado == 5)
                                    @if($articulo->fecha_reenvio == $articulo->updated_at)
                                        <button type="button" class="btn btn-secondary" disabled>
                                            Artículo reenviado <i class="fa fa-check"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#archivoModal-{{ $articulo->id_articulo }}" title="Cargar Archivo">
                                            Reenviar Artículo <i class="fa fa-file"></i>
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Observaciones -->
                        <div class="modal fade" id="observacionesModal-{{ $articulo->id_articulo }}" tabindex="-1" aria-labelledby="observacionesModalLabel-{{ $articulo->id_articulo }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="observacionesModalLabel-{{ $articulo->id_articulo }}">Observaciones del Pago</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $articulo->observacion }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Nuevo Archivo -->
                        <div class="modal fade" id="archivoModal-{{ $articulo->id_articulo }}" tabindex="-1" aria-labelledby="archivoModalLabel-{{ $articulo->id_articulo }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="archivoModalLabel-{{ $articulo->id_articulo }}">Cargar Archivo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('articulos.updateArchivo', $articulo->id_articulo) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <input id="archivoNombre" type="file" name="archivo" class="form-control" placeholder="Inserte el nuevo archivo word" value="{{old("archivo")}}" accept=".doc,.docx" required>
                                            <div id="emailHelp" class="form-text">Selecciona artículo en formato word.</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
            </div>
            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
    </div>

    @if(Session::has('success'))
        <script>
            toastr.success('{{ Session::get('success') }}')
        </script>
    @endif
@endsection

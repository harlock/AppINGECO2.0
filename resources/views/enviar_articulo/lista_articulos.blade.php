@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div class="row justify-content-center mt-4">
        <div class="col-11">

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

            <div class="table-responsive-xl bg-white border rounded-lg mt-4 p-3 shadow-sm tab-pane fade show active" id="home"
                 role="tabpanel" aria-labelledby="home-tab">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Revista</th>
                        <th class="text-center">Nombre del artículo</th>
                        <th class="text-center">Modalidad</th>
                        <th class="text-center">Archivo</th>
                        <th class="text-center">Mesa asignada</th>
                        <th class="text-center">Comprobante de pago</th>
                        <th class="text-center"></th>
                        <th class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($articulos as $articulo)
                        <tr class="{{ $articulo->estado == 0 ? 'bg-gray-100' : ($articulo->estado == 1 ? 'bg-green-100' : ($articulo->estado == 2 ? 'bg-red-100' : ($articulo->estado == 5 ? 'bg-blue-100' : 'bg-yellow-100'))) }}">
                            <td class="">
                                @if($articulo->estado == 0)
                                    <i class="bi bi-bookmark-dash-fill"></i> Sin revisar
                                @elseif($articulo->estado == 1)
                                    <i class="bi bi-bookmark-check-fill"></i> Aceptado
                                @elseif($articulo->estado == 2)
                                    <i class="bi bi-bookmark-x-fill"></i> Rechazado
                                @elseif($articulo->estado == 5)
                                    <i class="bi bi-bookmark-star-fill"></i> Aceptado con cambios
                                @else
                                    <i class="bi bi-bookmark-dash-fill"></i> En proceso de revisión
                                @endif
                            </td>
                            <td>{{$articulo->revista }}</td>
                            <td class="text-wrap text-break">{{$articulo->titulo }}</td>
                            <td>{{$articulo->modalidad }}</td>
                            <td class="font-semibold ">
                                <a class="btn btn-primary" href="{{route('art.download',$articulo->titulo)}}">Descargar
                                    <i class="bi bi-arrow-down-square-fill"></i></a>
                            </td>
                            <td class="text-wrap text-break">{{$articulo->descripcion }}</td>
                            <td>
                                @php
                                    $comprobanteExistente = App\Models\ComprobantePago::where('id_articulo', $articulo->id_articulo)->first();
                                @endphp

                                @if($articulo->estado == 1 || $articulo->estado == 5)
                                    @if($comprobanteExistente && $comprobanteExistente->deleted_at)
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#comprobanteModal-{{ $articulo->id_articulo }}">
                                            Agregar nuevo comprobante de pago
                                        </button>
                                    @elseif(!$comprobanteExistente)
                                        <!-- Si no existe ningún comprobante, muestra el botón como habilitado -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#comprobanteModal-{{ $articulo->id_articulo }}">
                                            Agregar comprobante de pago
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success" disabled>
                                            Comprobante enviado
                                        </button>
                                    @endif
                                @endif

                                <!-- Modal -->
                                <div class="modal fade" id="comprobanteModal-{{ $articulo->id_articulo }}" tabindex="-1"
                                     aria-labelledby="comprobanteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="comprobanteModalLabel">Agregar Comprobante de
                                                    Pago</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('comprobantes.store') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_articulo"
                                                           value="{{ $articulo->id_articulo }}">
                                                    <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                                                    <div class="mb-3">
                                                        <label for="comprobante" class="form-label">Comprobante de pago
                                                            (PDF)</label>
                                                        <input type="file" class="form-control" id="comprobante"
                                                               name="comprobante" accept="application/pdf">
                                                        <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>

                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="referencia" class="form-label">Referencia</label>
                                                        <input type="text" class="form-control" id="referencia"
                                                               name="referencia">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">¿Requiere factura?</label>
                                                        <div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                       name="factura" id="factura_si_{{ $articulo->id_articulo }}"
                                                                       value="1">
                                                                <label class="form-check-label"
                                                                       for="factura_si_{{ $articulo->id_articulo }}">Sí</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                       name="factura" id="factura_no_{{ $articulo->id_articulo }}"
                                                                       value="0">
                                                                <label class="form-check-label"
                                                                       for="factura_no_{{ $articulo->id_articulo }}">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3" id="constancia_fiscal_group_{{ $articulo->id_articulo }}"
                                                         style="display: none;">
                                                        <label for="constancia_fiscal_{{ $articulo->id_articulo }}"
                                                               class="form-label">Constancia de situación fiscal (PDF)</label>
                                                        <input type="file" class="form-control" id="constancia_fiscal_{{ $articulo->id_articulo }}"
                                                               name="constancia_fiscal" accept="application/pdf">
                                                        <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.querySelectorAll('input[name="factura"]').forEach((elem) => {
                                        elem.addEventListener('change', function (event) {
                                            const articuloId = event.target.closest('.modal').id.split('-').pop();
                                            const constanciaFiscalGroup = document.getElementById(`constancia_fiscal_group_${articuloId}`);
                                            if (event.target.value == 1) {
                                                constanciaFiscalGroup.style.display = 'block';
                                            } else {
                                                constanciaFiscalGroup.style.display = 'none';
                                            }
                                        });
                                    });
                                </script>
                            </td>
                            <td>
                                @if($articulo->observacion)
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#observacionesModal-{{ $articulo->id_articulo }}" title="Ver Observaciones">
                                        <i class="fa fa-comments"></i>
                                    </button>
                                @endif
                            </td>
                            <td>
                                @if($articulo->estado == 5)
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#archivoModal-{{ $articulo->id_articulo }}" title="Cargar Archivo">
                                        <i class="fa fa-file"></i>
                                    </button>
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
                                        </div>
                                    </form>
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

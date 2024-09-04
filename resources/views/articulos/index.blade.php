@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{--********************************************************************************************************--}}
    <div class="row justify-content-center">
        <div class="col-11 justify-content-center my-5 mx-10">
            <div class="">

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
                <div class="col bg-blue-800 rounded-lg">
                    <h3 class=" justify-content-center alert  d-flex text-white ">
                        Ver Artículos
                    </h3>
                </div>
                <div>
                    <form class="p-2" action="{{ route('list.art') }}" method="GET">
                        <div class="form-row p-2">
                            <h3>Buscador de artículos</h3>
                            <div class="d-flex justify-content-center p-2">
                                <input id="textoBusqueda" type="text" name="texto" class="form-control"
                                       placeholder="Ingresa nombre de revista, modalidad o nombre del artículo.">
                                <input type="submit" value="Buscar" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#textoBusqueda').on('input', function() {
                                var texto = $(this).val();

                                $.ajax({
                                    url: "{{ route('list.art') }}",
                                    method: "GET",
                                    data: {
                                        texto: texto
                                    },
                                    success: function(data) {
                                        $('#tablaNombres').html($(data).find('#tablaNombres').html());
                                    }
                                });
                            });
                        });
                    </script>
                    <script>
                        $(document).ready(function() {
                            $('.btn-texto').click(function() {
                                var texto = $(this).data('texto');
                                window.location.href = "{{ route('list.art', ['texto' => '']) }}/" + texto;
                            });
                        });
                    </script>
                    <div class="d-flex  ">
                        <button class="btn bg-yellow-100 btn-texto m-1 " data-texto="4">En proceso de revisión </button>
                        <button class="btn bg-green-100 btn-texto m-1" data-texto="1">Aceptado</button>
                        <button class="btn bg-red-100 btn-texto m-1" data-texto="2">Rechazado</button>
                        <button class="btn bg-blue-100 btn-texto m-1" data-texto="5">Aceptado condicionado</button>
                        <form class=" m-1 " action="{{ route('list.art') }}" method="GET">
                            <button class="btn bg-gray-300 " type="submit">Quitar filtro </button>
                        </form>
                    </div>
                </div>
                <div class="tab-content rounded-lg" id="tabContent">

                    <div class=" table-responsive-xl bg-white border rounded-lg mt-4 p-3 shadow-sm tab-pane fade show active"
                         id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table ">
                            <thead>
                            <tr class="bg-gray-100 text-black">
                                <th>ID</th>
                                <th class="">Revista</th>
                                <th class="">Modalidad</th>
                                <th class="">Correo</th>
                                <th class="">Nombre del artículo</th>
                                <th class="">Estado</th>
                                <th class="">Archivo Artículo</th>
                                <th class="">Archivo Antiplagio</th>
                                <th class="">Archivo Derechos</th>
                                <th class="">Evaluación</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="tablaNombres">
                            @foreach($Artic as $articu)
                                @php
                                    $correoAutor = $autores[$articu->id_articulo]->correo ?? 'No está registrado';
                                @endphp
                                <tr class="{{$articu->estado == 0 ? "bg-gray-100" : ($articu->estado == 1 ? "bg-green-100" : ($articu->estado == 2 ? "bg-red-100" : ($articu->estado == 5 ? 'bg-blue-100' : "bg-yellow-100")))}}">
                                    <td class="">
                                        {{$articu->id_articulo}}
                                    </td>
                                    <td class=" ">
                                        {{$articu->revista}}
                                    </td>
                                    <td class="">
                                        {{$articu->modalidad}}
                                    </td>
                                    <td class=" ">
                                        {{ $correoAutor }}
                                    </td>

                                    <td class=" text-wrap text-break">
                                        {{$articu->titulo}}
                                    </td>
                                    <td class="">
                                        @if($articu->estado == 0)
                                            <i class="bi bi-bookmark-dash-fill"></i> Sin revisar
                                        @elseif($articu->estado == 1)
                                            <i class="bi bi-bookmark-check-fill"></i> Aceptado
                                        @elseif($articu->estado == 2)
                                            <i class="bi bi-bookmark-x-fill"></i> Rechazado
                                        @elseif($articu->estado == 5)
                                            <i class="bi bi-bookmark-star-fill"></i> Aceptado condicionado
                                        @else
                                            <i class="bi bi-bookmark-dash-fill"> </i> En proceso de revisión
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('art.download',$articu->titulo)}}">Descargar <i
                                                    class="bi bi-arrow-down-square-fill"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary" href="{{ route('art.downloadPlagio', $articu->titulo) }}">Antiplagio
                                            <i class="bi bi-arrow-down-square-fill"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $archivoDerecho = \App\Models\ArchivosDerechos::where('id_articulo', $articu->id_articulo)->first();
                                        @endphp

                                        @if($archivoDerecho)
                                            @if($archivoDerecho->estado == 1)
                                                <a class="btn btn-primary" href="{{ route('art.downloadArchivoDerecho', $articu->id_articulo) }}">
                                                    Descargar Archivo de Derechos <i class="bi bi-arrow-down-square-fill"></i>
                                                </a>
                                            @elseif($archivoDerecho->estado == 2)
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                    Rechazado
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalRevisar{{$articu->id_articulo}}">
                                                    Revisar Archivo de Derechos
                                                </button>
                                            @endif
                                        @else
                                            @if($articu->estado == 1)
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                    No Disponible
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                    No Disponible
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        @if($articu->estado != 1 && $articu->estado != 2)
                                            @if($articu->fecha_reenvio == $articu->updated_at)
                                                <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modal{{$articu->id_articulo}}">
                                                    Evaluar <i class="bi bi-arrow-right-square-fill"></i>
                                                </button>
                                                @include("articulos.modal_evaluate")
                                            @elseif($articu->updated_at > $articu->created_at)
                                                <button type="button" class="btn btn-dark btn-sm" disabled>
                                                    En espera <i class="bi bi-arrow-right-square-fill"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modal{{$articu->id_articulo}}">
                                                    Evaluar <i class="bi bi-arrow-right-square-fill"></i>
                                                </button>
                                                @include("articulos.modal_evaluate")
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-dark btn-sm" disabled>
                                                Evaluado <i class="bi bi-arrow-right-square-fill"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400"></td>
                                <td class="bg-gray-400 d-flex justify-content-center">
                                    {{--
                                    <a class="btn btn-danger" href="{{url('download_zip')}}">Descargar ZIP <i class="bi bi-arrow-down-square-fill"></i></a>
                                    --}}
                                </td>
                                <td class="bg-gray-400"></td>
                            </tr>
                            <!-- Modal de revisar archivo de derechos de publicación -->
                            @foreach($Artic as $articu)
                                <!-- Modal de revisar archivo de derechos de publicación-->
                                <div class="modal fade" id="modalRevisar{{$articu->id_articulo}}" tabindex="-1" aria-labelledby="modalRevisarLabel{{$articu->id_articulo}}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg"> <!-- Hacemos el modal más largo hacia abajo -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalRevisarLabel{{$articu->id_articulo}}">Revisar Archivo de Derechos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                    $archivoDerecho = \App\Models\ArchivosDerechos::where('id_articulo', $articu->id_articulo)->first();
                                                @endphp

                                                @if($archivoDerecho)
                                                    <a class="btn btn-primary mb-3" href="{{ route('art.downloadArchivoDerecho', $articu->id_articulo) }}">
                                                        Descargar Archivo de Derechos <i class="bi bi-arrow-down-square-fill"></i>
                                                    </a>
                                                @else
                                                    <p>No hay archivo de derechos disponible.</p>
                                                @endif

                                                <!-- Formulario para actualizar el estado y mensaje -->
                                                <form id="formRevisar{{$articu->id_articulo}}" action="{{ route('art.updateArchivoDerecho', $articu->id_articulo) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mt-3">
                                                        <label for="estado{{$articu->id_articulo}}" class="form-label">Evaluar</label>
                                                        <select id="estado{{$articu->id_articulo}}" name="estado" class="form-select">
                                                            <option value="0" selected="true" disabled="true">Seleccionar estado</option>
                                                            <option class="" value="1">Aceptar</option>
                                                            <option class="" value="2">Rechazar</option>
                                                        </select>
                                                    </div>

                                                    <!-- Área de texto para el mensaje, inicialmente oculta -->
                                                    <div class="mt-3" id="mensajeContainer{{$articu->id_articulo}}" style="display: {{ $archivoDerecho && $archivoDerecho->estado == 2 ? 'block' : 'none' }};">
                                                        <label for="mensaje{{$articu->id_articulo}}" class="form-label">Mensaje</label>
                                                        <textarea id="mensaje{{$articu->id_articulo}}" name="mensaje" class="form-control" rows="4" placeholder="Escribe tu mensaje aquí...">{{ $archivoDerecho->mensaje ?? '' }}</textarea>
                                                    </div>

                                                    <!-- Botón para guardar los cambios -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        document.getElementById('estado{{$articu->id_articulo}}').addEventListener('change', function () {
                                            var estado = this.value;
                                            var mensajeContainer = document.getElementById('mensajeContainer{{$articu->id_articulo}}');
                                            if (estado === '2') {
                                                mensajeContainer.style.display = 'block';
                                            } else {
                                                mensajeContainer.style.display = 'none';
                                            }
                                        });
                                    });
                                </script>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Session::has('success'))
        <script>
            toastr.success('{{ Session::get('success') }}')
        </script>
    @endif
@endsection

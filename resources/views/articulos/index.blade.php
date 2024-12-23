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
                                <th class="text-center">Revista</th>
                                <th class="text-center">Modalidad</th>
                                <th class="text-center">Correo</th>
                                <th class="text-center">Nombre del artículo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Archivos Descargables</th>
                                <th class="text-center">Evaluación</th>
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
                                        <!-- Botón para descargar el artículo -->
                                        <a class="btn btn-primary d-block mb-2" href="{{ route('art.download', $articu->titulo) }}">
                                            <i class="bi bi-file-earmark-text-fill"></i> Descargar Artículo
                                        </a>

                                        <!-- Botón para descargar el archivo antiplagio -->
                                        <a class="btn btn-primary  d-block mb-2" href="{{ route('art.downloadPlagio', $articu->titulo) }}">
                                            <i class="bi bi-shield-lock-fill"></i> Antiplagio
                                        </a>

                                        <!-- Verificar si existe el archivo de cesión de derechos -->
                                        @php
                                            $archivoDerecho = \App\Models\ArchivosDerechos::where('id_articulo', $articu->id_articulo)->first();
                                        @endphp

                                        @if($archivoDerecho)
                                            @if($archivoDerecho->estado == 1)
                                                <!-- Botón para descargar la carta de cesión de derechos si está aceptada -->
                                                <a class="btn btn-primary  d-block mb-2" href="{{ route('art.downloadArchivoDerecho', $articu->id_articulo) }}">
                                                    <i class="bi bi-file-earmark-check-fill"></i> Cesión de Derechos
                                                </a>
                                            @elseif($archivoDerecho->estado == 2)
                                                <!-- Botón para mostrar que la carta de derechos fue rechazada -->
                                                <button type="button" class="btn btn-danger d-block mb-2" disabled>
                                                    <i class="bi bi-x-circle-fill"></i> Carta Rechazada
                                                </button>
                                            @else
                                                <!-- Botón para revisar la carta de cesión de derechos (en modal) -->
                                                <button type="button" class="btn btn-warning  d-block mb-2" data-bs-toggle="modal" data-bs-target="#modalRevisar{{$articu->id_articulo}}">
                                                    <i class="bi bi-file-earmark-text-fill"></i> Revisar Carta
                                                </button>
                                            @endif
                                        @else
                                            <!-- Mostrar el botón "No Disponible" si no hay archivo de derechos -->
                                            <button type="button" class="btn btn-secondary  d-block mb-2" disabled>
                                                <i class="bi bi-slash-circle-fill"></i> No Disponible
                                            </button>
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

                                <td class="bg-gray-400 d-flex justify-content-center">
                                    {{--
                                    <a class="btn btn-danger" href="{{url('download_zip')}}">Descargar ZIP <i class="bi bi-arrow-down-square-fill"></i></a>
                                    --}}
                                </td>
                                <td class="bg-gray-400"></td>
                            </tr>

                            <!-- Modal de revisar archivo de derechos de publicación -->
                            @foreach($Artic as $articu)
                                <div class="modal fade" id="modalRevisar{{$articu->id_articulo}}" tabindex="-1" aria-labelledby="modalRevisarLabel{{$articu->id_articulo}}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalRevisarLabel{{$articu->id_articulo}}">Revisar Carta de Cesión de Derechos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                    $archivoDerecho = \App\Models\ArchivosDerechos::where('id_articulo', $articu->id_articulo)->first();
                                                @endphp

                                                @if($archivoDerecho)
                                                    <a class="btn btn-primary mb-3" href="{{ route('art.downloadArchivoDerecho', $articu->id_articulo) }}">
                                                        Descargar Carta de Cesión de Derechos <i class="bi bi-arrow-down-square-fill"></i>
                                                    </a>
                                                @else
                                                    <p>No hay archivo de carta de Cesión de Derechos Disponible.</p>
                                                @endif

                                                <!-- Formulario para actualizar el estado y mensaje -->
                                                <form id="formRevisar{{$articu->id_articulo}}" action="{{ route('art.updateArchivoDerecho', $articu->id_articulo) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mt-3">
                                                        <label for="estado{{$articu->id_articulo}}" class="form-label">Evaluar</label>
                                                        <select id="estado{{$articu->id_articulo}}" name="estado" class="form-select" required>
                                                            <option value="0" selected="true" disabled="true">Seleccionar estado</option>
                                                            <option class="" value="1">Aceptar</option>
                                                            <option class="" value="2">Rechazar</option>
                                                        </select>
                                                    </div>

                                                    <div class="mt-3" id="mensajeContainer{{$articu->id_articulo}}" style="display: {{ $archivoDerecho && $archivoDerecho->estado == 2 ? 'block' : 'none' }};">
                                                        <label for="mensaje{{$articu->id_articulo}}" class="form-label">Mensaje</label>
                                                        <textarea id="mensaje{{$articu->id_articulo}}" name="mensaje" class="form-control" rows="4" placeholder="Escribe tu mensaje aquí..." maxlength="250">{{ $archivoDerecho->mensaje ?? '' }}</textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>

                                                <script>
                                                    const estadoSelect = document.getElementById('estado{{$articu->id_articulo}}');
                                                    const mensajeTextarea = document.getElementById('mensaje{{$articu->id_articulo}}');
                                                    const mensajeContainer = document.getElementById('mensajeContainer{{$articu->id_articulo}}');

                                                    estadoSelect.addEventListener('change', function() {
                                                        if (this.value == 2) { // Si el estado es "Rechazar"
                                                            mensajeContainer.style.display = 'block';
                                                            mensajeTextarea.setAttribute('required', 'required'); // Agregar required
                                                        } else {
                                                            mensajeContainer.style.display = 'none';
                                                            mensajeTextarea.removeAttribute('required'); // Quitar required
                                                        }
                                                    });

                                                    // Opcional: Si ya hay un estado seleccionado al cargar el formulario, verificar y ajustar el mensaje
                                                    if (estadoSelect.value == 2) {
                                                        mensajeContainer.style.display = 'block';
                                                        mensajeTextarea.setAttribute('required', 'required');
                                                    }
                                                </script>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    const estadoSelect = document.getElementById('estado{{$articu->id_articulo}}');
                                    const mensajeContainer = document.getElementById('mensajeContainer{{$articu->id_articulo}}');
                                    const mensajeInput = document.getElementById('mensaje{{$articu->id_articulo}}');

                                    estadoSelect.addEventListener('change', function()
                                    {
                                        if (estadoSelect.value == '2')
                                        {
                                            mensajeContainer.style.display = 'block';
                                            mensajeInput.required = true; // Hacer el campo de mensaje obligatorio
                                        }
                                        else
                                        {
                                            mensajeContainer.style.display = 'none';
                                            mensajeInput.required = false;
                                        }
                                    });
                                </script>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function ()
                                    {
                                        document.getElementById('estado{{$articu->id_articulo}}').addEventListener('change', function ()
                                        {
                                            var estado = this.value;
                                            var mensajeContainer = document.getElementById('mensajeContainer{{$articu->id_articulo}}');
                                            if (estado === '2')
                                            {
                                                mensajeContainer.style.display = 'block';
                                            } else
                                            {
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

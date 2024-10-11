@extends('layouts.app')
@section('content')
{{--********************************************************************************************************--}}
<div class="row justify-content-center">
    <div class="col-11 justify-content-center my-5 mx-10">
        <div class="">
            <div class="col bg-blue-800 rounded-lg">
                <h3 class=" justify-content-center alert  d-flex text-white ">
                    Ver Artículos
                </h3>
            </div>
            <form class="p-2" action="{{ route('vista.artic.rev') }}" method="GET">
                <div class="form-row p-2">
                    <h3>Buscador de revista, artículos, nombre del evaluador o modalidad.</h3>
                    <div class="d-flex justify-content-center p-2">
                        <input id="textoBusqueda" type="text" name="texto" class="form-control" placeholder="Ingresa revista, título del artículo, nombre del evaluador o modalidad">
                        <input type="submit" value="Buscar" class="btn btn-primary">
                    </div>
                </div>
            </form>
            <div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#textoBusqueda').on('input', function() {
                            var texto = $(this).val();

                            $.ajax({
                                url: "{{ route('vista.artic.rev') }}",
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
                            window.location.href = "{{ route('vista.artic.rev', ['texto' => '']) }}/" + texto;
                        });
                    });
                </script>
                <div class="d-flex  ">
                    <button class="btn bg-gray-500 text-white m-1" data-texto="0">Sin asignar</button>
                    <button class="btn bg-yellow-100 btn-texto m-1 " data-texto="4">En proceso de revisión </button>
                    <button class="btn bg-green-100 btn-texto m-1" data-texto="1">Aceptado</button>
                    <button class="btn bg-red-100 btn-texto m-1" data-texto="2">Rechazado</button>
                    <button class="btn bg-blue-100 btn-texto m-1" data-texto="5">Aceptado condicionado</button>
                    <form class=" m-1 " action="{{ route('vista.artic.rev') }}" method="GET">
                        <button class="btn bg-gray-300 " type="submit">Quitar filtro </button>
                    </form>
                </div>

                <div class="p-1">
                    <div class="">
                        <form class="" action="{{ route('descargar.excel') }}" method="POST">
                            @csrf
                            <input type="hidden" name="datos" value="{{ json_encode($Artic) }}">
                            <button class="btn bg-gray-200" type="submit">Descargar en Excel</button>
                        </form>
                    </div>

                </div>
            </div>

            <div class="tab-content rounded-lg" id="tabContent">
                <div class=" table-responsive-xl bg-white border rounded-lg mt-4 p-3 shadow-sm tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table rounded-lg">
                        <thead class="rounded-lg">
                            <tr class="bg-gray-100 text-black rounded-lg">
                                <th>#</th>
                                <th class="font-bold text-center">Revista</th>
                                <th class="font-bold text-center">Nombre del artículo</th>
                                <th class="font-bold text-center">Evaluador</th>
                                <th class="font-bold text-center">Modalidad</th>
                                <th class="font-bold text-center">Estado</th>
                                <th class="font-bold text-center">Archivo Artículo</th>
                                <th class="font-bold text-center">Archivo Antiplagio</th>
                                <th class="font-bold text-center">Carta de Sesión de Derechos</th>

                            </tr>
                        </thead>
                        <tbody id="tablaNombres">
                        @foreach($Artic as $articu)
                        <tr class="rounded-xl {{$articu->estado == 0 ? "bg-gray-100" : ($articu->estado == 1 ? "bg-green-100" : ($articu->estado == 2 ? "bg-red-100" : ($articu->estado == 5 ? 'bg-blue-100' : "bg-yellow-100")))}}">
                            <td class="text-center">
                                {{$loop->index+1}}
                            </td>
                            <td class="text-center">
                                {{$articu->revista}}
                            </td>
                            <td class=" text-wrap text-break text-center">
                                {{$articu->titulo}}
                            </td>
                            <td class="text-wrap text-break text-center">
                                {{$articu->nombreCompleto??''}}
                            </td>
                            <td class=" text-wrap text-break text-center">
                                {{$articu->modalidad}}
                            </td>
                            <td class="text-center">
                                @if($articu->estado == 0)
                                <i class="bi bi-bookmark-dash-fill"></i> Sin revisar
                                @elseif($articu->estado == 1)
                                <i class="bi bi-bookmark-check-fill"></i> Aceptado
                                @elseif($articu->estado == 2)
                                    <i class="bi bi-bookmark-x-fill"></i> Rechazado
                                @elseif($articu->estado == 5)
                                    <i class="bi bi-bookmark-star-fill"></i> Aceptado condicionado
                                @else
                                <i class="bi bi-bookmark-dash-fill"></i> En proceso de revisión
                                @endif
                            </td>



                            <td class="text-center">
                                <a class="btn btn-primary" href="{{route('art.download',$articu->titulo)}}">Artículo <i class="bi bi-arrow-down-square-fill"></i></a>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="{{ route('art.downloadPlagio', $articu->titulo) }}"> Antiplagio
                                    <i class="bi bi-arrow-down-square-fill"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                @php
                                    // Obtener el archivo de derechos desde la base de datos
                                    $archivoDerecho = \App\Models\ArchivosDerechos::where('id_articulo', $articu->id_articulo)->first();
                                @endphp

                                @if($archivoDerecho)
                                    <a class="btn btn-primary" href="{{ route('art.downloadArchivoDerecho', $articu->id_articulo) }}">Carta de Cesión de Derechos
                                        <i class="bi bi-arrow-down-square-fill"></i>
                                    </a>
                                @else
                                    @if($articu->estado == 1)
                                        <button type="button" class="btn btn-secondary btn-sm">
                                            No Disponible
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm">
                                            No Disponible
                                        </button>
                                    @endif
                                @endif
                            </td>


                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
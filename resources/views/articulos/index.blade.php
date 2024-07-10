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
                                <th class="">Artículo</th>
                                <th class="">Evaluación</th>
                                <th class="">Consultar Pagos</th>
                            </tr>
                            </thead>
                            <tbody id="tablaNombres">
                            @foreach($Artic as $articu)
                                <tr class="{{$articu->estado == 0 ? "bg-gray-100" : ($articu->estado == 1 ? "bg-green-100" : ($articu->estado == 2 ? "bg-red-100" : "bg-yellow-100"))}}">
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
                                        {{$articu->arti()->email}}
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
                                        @else
                                            <i class="bi bi-bookmark-dash-fill"> </i> En proceso de revisión
                                        @endif
                                    </td>
                                    <td class="">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('art.download',$articu->titulo)}}">Descargar <i
                                                    class="bi bi-arrow-down-square-fill"></i></a>
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modal{{$articu->id_articulo}}">
                                            Evaluar <i class="bi bi-arrow-right-square-fill"></i>
                                        </button>
                                        @include("articulos.modal_evaluate")

                                    </td>
                                    <td>
                                        <!-- Button to trigger payment details modal -->
                                        <button type="button" class="btn btn-primary btn-sm consultar-pagos-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#consultarPagosModal{{$articu->id_articulo}}">
                                            Consultar Pagos <i class="bi bi-cash-coin"></i>
                                        </button>

                                        <!-- Modal para consultar pagos -->
                                        <div class="modal fade" id="consultarPagosModal{{$articu->id_articulo}}" tabindex="-1" aria-labelledby="consultarPagosModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="consultarPagosModalLabel">Consultar Pagos</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Comprobante</th>
                                                                <th>Referencia</th>
                                                                <th>Factura</th>
                                                                <th>Constancia Fiscal</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($pagos as $pago)
                                                                @if ($pago->id_articulo == $articu->id_articulo)
                                                                    <tr>
                                                                        <td>{{$pago->comprobante}}</td>
                                                                        <td>{{$pago->referencia}}</td>
                                                                        <td>{{$pago->factura}}</td>
                                                                        <td>{{$pago->constancia_fiscal}}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            <tr>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

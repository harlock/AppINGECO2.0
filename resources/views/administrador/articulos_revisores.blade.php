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
            <form class="p-2" action="{{ route('art.admin') }}" method="GET">
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
                                url: "{{ route('art.admin') }}",
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
                            window.location.href = "{{ route('art.admin', ['texto' => '']) }}/" + texto;
                        });
                    });
                </script>
                <div class="d-flex  ">
                    <button class="btn bg-yellow-100 btn-texto m-1 " data-texto="4">En proceso de revisión </button>
                    <button class="btn bg-green-100 btn-texto m-1"  data-texto="1">Aceptado</button>
                    <button class="btn bg-red-100 btn-texto m-1"  data-texto="2">Rechazado</button>
                    <button class="btn bg-blue-100 btn-texto m-1"  data-texto="5">Aceptado con cambios</button>
                    <button class="btn bg-green-100 btn-texto m-1" data-texto="7">Pagos Aceptados</button>
                    <form class=" m-1 " action="{{ route('art.admin') }}" method="GET">
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
                        <div class="alert alert-success">Total de registros: {{count($Artic)}}</div>
                        <table class="table rounded-lg">
                            <thead class="rounded-lg">
                                <tr class="bg-gray-100 text-black rounded-lg">
                                    <th>ID</th>
                                    <th class="font-bold">Revista</th>
                                    <th class="font-bold">Mesa</th>
                                    <th class="font-bold">Nombre del artículo</th>
                                    <th class="font-bold">Autor</th>


                                    <th class="font-bold">Modalidad</th>
                                    <th class="font-bold">Estado</th>
                                    <th class="font-bold"></th>
                                    <th class="font-bold"></th>
                                    <th class="font-bold"></th>
                                </tr>
                            </thead>
                            <tbody id="tablaNombres">
                            @foreach($Artic as $articu)
                                @php
                                    $nomAutor = $autores[$articu->id_articulo]->nom_autor ?? 'No está registrado';
                                    $apAutor = $autores[$articu->id_articulo]->ap_autor ?? 'No está registrado';
                                    $amAutor = $autores[$articu->id_articulo]->am_autor ?? 'No está registrado';
                                    $correoAutor = $autores[$articu->id_articulo]->correo ?? 'No está registrado';
                                    $telAutor = $autores[$articu->id_articulo]->tel ?? 'No está registrado';
                                @endphp
                            <tr class="rounded-xl {{$articu->estado == 0 ? "bg-gray-100" : ($articu->estado == 1 ? "bg-green-100" : ($articu->estado == 2 ? "bg-red-100" : ($articu->estado == 5 ? 'bg-blue-100' : "bg-yellow-100")))}}">
                                <td class=""><strong>
                                    {{$articu->id_articulo}}

                                </strong>
                                </td>
                                <td class="">
                                    {{$articu->revista}}
                                </td>
                                <td class="text-wrap text-break">
                                    {{$articu->descripcion}}
                                </td>
                                <td class="text-wrap text-break">
                                    {{$articu->titulo}}
                                </td>
                                <td class="text-wrap text-break">
                                    {{ $nomAutor }}
                                    {{ $apAutor }}
                                    {{ $amAutor }}
                                    {{ $correoAutor }}
                                    {{ $telAutor }}
                                </td>
                               
                                <td class=" text-wrap text-break">
                                    {{$articu->modalidad}}
                                </td>
                                <td class="t-wrap text-break">
                                    @if($articu->estado == 0)
                                    <i class="bi bi-bookmark-dash-fill"></i> Sin revisar
                                    @elseif($articu->estado == 1)
                                    <i class="bi bi-bookmark-check-fill"></i> Aceptado
                                    @elseif($articu->estado == 2)
                                    <i class="bi bi-bookmark-x-fill"></i> Rechazado
                                    @elseif($articu->estado == 5)
                                        <i class="bi bi-bookmark-star-fill"></i> Aceptado con cambios
                                    @else
                                    <i class="bi bi-bookmark-dash-fill"></i> En proceso de revisión
                                    @endif
                                </td>



                                <td class="text-center">
                                    <a class="btn btn-primary" href="{{route('art.download',$articu->titulo)}}">Descargar <i class="bi bi-arrow-down-square-fill"></i></a>
                                    <div class="mt-2">
                                        <a class="btn btn-danger" href="{{ route('art.downloadPlagio', $articu->titulo) }}">Antiplagio
                                            <i class="bi bi-arrow-down-square-fill"></i>
                                        </a>
                                    </div>
                                    @if(!empty($articu->carta_aceptacion))
                                        <div class="mt-2">
                                            <a class="btn btn-success" href="{{ route('art.downloadCarta', $articu->titulo) }}">
                                                Carta Aceptación <i class="bi bi-arrow-down-square-fill"></i>
                                            </a>
                                        </div>
                                    @endif

                                    <div class="mt-2">
                                        @php
                                            // Obtener el archivo de derechos desde la base de datos
                                            $archivoDerecho = \App\Models\ArchivosDerechos::where('id_articulo', $articu->id_articulo)->first();
                                        @endphp

                                        @if($archivoDerecho)
                                            <a class="btn btn-warning" href="{{ route('art.downloadArchivoDerecho', $articu->id_articulo) }}">
                                                Carta de Cesión de Derechos <i class="bi bi-arrow-down-square-fill"></i>
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
                                    </div>

                                </td>

                                <td>
                                    @if (in_array($articu->id_articulo, $articulosConPagos))
                                        @php
                                            $estadoPago = $comprobanteUrls[$articu->id_articulo]['estado_pago'] ?? 2;
                                        @endphp

                                        @if ($estadoPago == 0)

                                        @else

                                            <button type="button" class="btn btn-primary btn-sm consultar-pagos-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#consultarPagosModal{{$articu->id_articulo}}">
                                                Consultar Pagos <i class="bi bi-cash-coin"></i>
                                            </button>
                                        @endif
                                    @else

                                    @endif
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
                                                                        <td>
                                                                            @if ($comprobanteUrls[$articu->id_articulo]['comprobante'])
                                                                                <a href="{{ $comprobanteUrls[$articu->id_articulo]['comprobante'] }}" target="_blank">Ver Comprobante</a>
                                                                            @else
                                                                                No hay comprobante de pago
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if (isset($comprobanteUrls[$articu->id_articulo]['referencia']))
                                                                                {{ $comprobanteUrls[$articu->id_articulo]['referencia'] }}
                                                                            @else
                                                                                No hay referencia de pago
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if (isset($comprobanteUrls[$articu->id_articulo]['factura']))
                                                                                {{ $comprobanteUrls[$articu->id_articulo]['factura'] == 1 ? 'Si' : 'No' }}
                                                                            @else
                                                                                Sin factura
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($comprobanteUrls[$articu->id_articulo]['constancia_fiscal'])
                                                                                <a href="{{ $comprobanteUrls[$articu->id_articulo]['constancia_fiscal'] }}" target="_blank">Ver Constancia</a>
                                                                            @else
                                                                                Sin Constancia fiscal
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
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
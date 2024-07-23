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
                        <button class="btn bg-blue-100 btn-texto m-1" data-texto="5">Aceptado con cambios</button>
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
                                <th class="">Regresar Pago</th>
                            </tr>
                            </thead>
                            <tbody id="tablaNombres">
                            @foreach($Artic as $articu)
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
                                        @elseif($articu->estado == 5)
                                            <i class="bi bi-bookmark-star-fill"></i> Aceptado con cambios
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
                                        @if($articu->estado != 1 && $articu->estado != 2 && $articu->estado != 5)
                                            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#modal{{$articu->id_articulo}}">
                                                Evaluar <i class="bi bi-arrow-right-square-fill"></i>
                                            </button>
                                            @include("articulos.modal_evaluate")
                                        @else
                                            <button type="button" class="btn btn-dark btn-sm" disabled>
                                                Evaluado <i class="bi bi-arrow-right-square-fill"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array($articu->id_articulo, $articulosConPagos))
                                            <!-- Button to trigger payment details modal -->
                                            <button type="button" class="btn btn-primary btn-sm consultar-pagos-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#consultarPagosModal{{$articu->id_articulo}}">
                                                Consultar Pagos <i class="bi bi-cash-coin"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm consultar-pagos-btn" disabled>
                                                Sin pago para consultar <i class="bi bi-x-circle"></i>
                                            </button>
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
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        @if (in_array($articu->id_articulo, $articulosConPagos))
                                            @if ($comprobanteUrls[$articu->id_articulo]['deleted_at'])
                                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                    Pago Regresado <i class="bi bi-x-circle"></i>
                                                </button>
                                            @else
                                                <!-- Button to trigger return payment modal -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#regresarPagoModal{{$articu->id_articulo}}">
                                                    Regresar Pago <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                                <!-- Modal para regresar pago -->
                                                <div class="modal fade" id="regresarPagoModal{{$articu->id_articulo}}" tabindex="-1" aria-labelledby="regresarPagoModalLabel{{$articu->id_articulo}}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="regresarPagoModalLabel{{$articu->id_articulo}}">¿Explica por qué deseas regresar el Pago?</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form class="regresar-pago-form" action="{{ route('regresar-pago', $articu->id_articulo) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="observacion{{$articu->id_articulo}}" class="form-label">Observación</label>
                                                                        <textarea id="observacion{{$articu->id_articulo}}" name="observacion" class="form-control" rows="3" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                    <button type="button" class="btn btn-danger regresar-pago-btn">Regresar Pago</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                Sin Pago <i class="bi bi-x-circle"></i>
                                            </button>
                                        @endif
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
    <script>
        // Script para mostrar SweetAlert antes de enviar el formulario de regreso de pago
        document.querySelectorAll('.regresar-pago-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, regresar pago'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @if(Session::has('success'))
        <script>
            toastr.success('{{ Session::get('success') }}')
        </script>
    @endif
@endsection

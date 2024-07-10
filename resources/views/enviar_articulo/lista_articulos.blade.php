@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div class="row justify-content-center mt-4">
        <div class="col-10">
            <div class="col">
                <h3 class="justify-content-center alert bg-blue-800 d-flex text-white">
                    Artículos enviados
                </h3>
            </div>
            <br>

            <div class="table-responsive-xl bg-white border rounded-lg mt-4 p-3 shadow-sm tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($articulos as $articulo)
                        <tr class="{{ $articulo->estado == 0 ? 'bg-gray-100' : ($articulo->estado == 1 ? 'bg-green-100' : ($articulo->estado == 2 ? 'bg-red-100' : 'bg-yellow-100')) }}">
                            <td class="">
                                @if($articulo->estado == 0)
                                    <i class="bi bi-bookmark-dash-fill"></i> Sin revisar
                                @elseif($articulo->estado == 1)
                                    <i class="bi bi-bookmark-check-fill"></i> Aceptado
                                @elseif($articulo->estado == 2)
                                    <i class="bi bi-bookmark-x-fill"></i> Rechazado
                                @else
                                    <i class="bi bi-bookmark-dash-fill"></i> En proceso de revisión
                                @endif
                            </td>
                            <td>{{$articulo->revista }}</td>
                            <td class="text-wrap text-break">{{$articulo->titulo }}</td>
                            <td>{{$articulo->modalidad }}</td>
                            <td class="font-semibold ">
                                <a class="btn btn-primary" href="{{route('art.download',$articulo->titulo)}}">Descargar <i class="bi bi-arrow-down-square-fill"></i></a>
                            </td>
                            <td class="text-wrap text-break">{{$articulo->descripcion }}</td>
                            <td>
                                @php
                                    $comprobanteExistente = App\Models\ComprobantePago::where('id_articulo', $articulo->id_articulo)->exists();
                                @endphp

                                @if($articulo->estado == 1 && !$comprobanteExistente)
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#comprobanteModal-{{ $articulo->id_articulo }}">
                                        Agregar comprobante de pago
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success" disabled>
                                        Comprobante enviado
                                    </button>
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
                                                        <input type="file" class="form-control" id="comprobante" name="comprobante" accept="application/pdf" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="referencia" class="form-label">Referencia</label>
                                                        <input type="text" class="form-control" id="referencia" name="referencia" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">¿Requiere factura?</label>
                                                        <div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="factura" id="factura_si_{{ $articulo->id_articulo }}" value="1" required>
                                                                <label class="form-check-label" for="factura_si_{{ $articulo->id_articulo }}">Sí</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="factura" id="factura_no_{{ $articulo->id_articulo }}" value="0" required>
                                                                <label class="form-check-label" for="factura_no_{{ $articulo->id_articulo }}">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3" id="constancia_fiscal_group_{{ $articulo->id_articulo }}" style="display: none;">
                                                        <label for="constancia_fiscal_{{ $articulo->id_articulo }}" class="form-label">Constancia de situación fiscal (PDF)</label>
                                                        <input type="file" class="form-control" id="constancia_fiscal_{{ $articulo->id_articulo }}" name="constancia_fiscal" accept="application/pdf">
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
                                    document.querySelectorAll('input[name="factura"]').forEach((elem) => {
                                        elem.addEventListener('change', function(event) {
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
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @if(Session::has('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ Session::get('success') }}");
            });
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ Session::get('error') }}");
            });
        </script>
    @endif

@endsection

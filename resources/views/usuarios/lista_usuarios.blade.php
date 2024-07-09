@extends('layouts.app')

@section('content')

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#textoBusqueda').on('input', function() {
                var texto = $(this).val();

                $.ajax({
                    url: "{{ route('home.users') }}",
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
    <div class="row px-10 py-4 ">
        <div class="row">
            <div class="col">
                <form action="{{ route('home.users') }}" method="GET">
                    <div class="form-row p-2">
                        <h3>Buscador de usuarios</h3>
                        <div class="d-flex justify-content-center p-2">
                            <input type="text" id="textoBusqueda" name="texto" value="{{ $texto }}" class="form-control" placeholder="Ingresar el nombre">
                            <input type="submit" id="buscar" value="Buscar" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
            <div class=" col">
                <h3>Total de usuarios creados</h3>
                @foreach($usuariosPorAnio as $usuarioPorAnio)
                <p>Año: {{ $usuarioPorAnio->anio }} - Total de usuarios: {{ $usuarioPorAnio->total }}</p>
                @endforeach
                <!-- Formulario para cambiar el año -->
                <form action="{{ route('home.users') }}" method="GET">
                    <div class="d-flex justify-content-center">
                        <h3 class="p-2" for="anio">Año:</h3>
                        <div>
                            <input type="number" class="buscador form-control border-lg rounded " name="anio" id="anio" value="{{ $anio }}" min="2010" max="{{ date('Y') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Mostrar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col bg-blue-800 rounded-lg">
            <h3 class=" justify-content-center alert  d-flex text-white ">
                Usuarios a asignar
            </h3>
        </div>
        <div class=" table-responsive-xl bg-white border rounded-lg mt-4 p-3 shadow-sm tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="table p-2 tabla" id="tabla-nombres">
                <thead>
                    <tr class="bg-gray-100 text-black ">
                        <th scope="d-flex justify-content-center">#</th>
                        <th scope="d-flex justify-content-center">Nombre</th>
                        <th scope="d-flex justify-content-center">Correo electrónico</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="tablaNombres">
                    @foreach($filtro_usuarios as $user)
                    <tr class="font-bold">
                        <td class="bg-gray-100">{{$loop->index+1}}</td>
                        <td>{{$user->nombreUsuarios}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal{{$user->id}}">
                                Asignar <i class="bi bi-arrow-right-square-fill"></i>
                            </button>
                            @include("usuarios.modal_validate")
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</body>


@endsection
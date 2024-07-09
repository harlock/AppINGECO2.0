@extends('layouts.app')

@section('content')

<div class="container px-5 py-5 p-lg-0 bg-surface-secondary">
    <div class="row justify-content-start">
        <div class="">
            @if($usuario)
            <div class="row pt-2 col ps-4 mr-4">
                <div class="mr-4">
                    <h1 class="display-6 mb-3">
                        <div>
                            <i class="bi bi-person-lines-fill"></i> {{ $usuario->name }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}
                        </div>
                    </h1>
                    <div class="p-2 px-5">
                        <a href="{{url('profileEdit')}}" role="button" class="btn btn-primary"><i class="bi bi-eye"></i> Editar datos</a>
                    </div>

                    <div>
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success p-4">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="border rounded-lg bg-white table-responsive-xl justify-content-center p-4">
                            <h2>Datos de perfil</h2>
                            <table class="table mt-3">
                                <div>
                                    <tr>
                                        <th class="row font-semibold text-center">
                                            <h3>Nombre(s):</h3>
                                        </th>
                                        <td>
                                            <h4>{{ $usuario->name }}</h4>
                                        </td>

                                        <th class="font-semibold text-center">
                                            <h3>Apellidos:</h3>
                                        </th>
                                        <td>
                                            <h4>{{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="row font-semibold text-center">
                                            <h3>Correo:</h3>
                                        </th>
                                        <td>
                                            <h4>{{ $usuario->email }}</h4>
                                        </td>

                                        <th class="row font-semibold text-center">
                                            <h3>Teléfono:</h3>
                                        </th>
                                        <td>
                                            <h4>{{ $usuario->telefono }}</h4>
                                        </td>
                                    </tr>
                                </div>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
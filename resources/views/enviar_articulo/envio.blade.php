@extends('layouts.app')
@section('content')
<div class=" container ">
    <div class="py-5">
        <div class="alert alert-success alert-dismissible fade show " role="alert" data-dismiss="alert" aria-label="Close">
            <div>
                <strong>¡Artículo enviado correctamente!</strong>
                <p>
                    Recuerda que estaremos enviando por correo tus resultados, en caso de ser aprobado tendrás que realizar el pago y la presentación para poder recibir la constancia.
                </p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <div class="features-icons bg-light text-center">
        <div class=" justify-content-center">
            <div class=" bg-light text-center">
                <div class="d-flex justify-content-center">
                    <div class="col bg-blue-600 p-4">
                        <!-- Logo -->
                        <img src="imagenes/logo blanco.png" class="" width="300" height="300">
                        <div class="p-3 ">
                            <h1 class="text-light fs-1">¡Artículo enviado correctamente!</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3 ">

                <p class="text-dark fs-1">
                    Recuerda que estaremos enviando por correo tus resultados,

                </p>
                <p class="text-dark fs-1">
                    en caso de ser aprobado tendrás que realizar el pago y la presentación para poder recibir la constancia.
                </p>

            </div>
            <a class="btn btn-primary " href="/"><i class="bi bi-box-arrow-left"></i> Inicio</a>
        </div>
    </div>

</div>
@endsection
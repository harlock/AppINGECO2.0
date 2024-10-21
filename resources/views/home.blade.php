@extends('layouts.app')

@section('content')

<div class="container  rounded-xl">
    <div class="row justify-content-center">
        <div class="  col-sm-11 col-md-11 col-lg-11  py-3 rounded-5">
            @if(Auth::user()->user_type===1)
            <div class=" ">
                <div class="bg-white rounded-xl shadow-sm ">
                    <div class="card-header text-center font-bold">{{ __('¡Bienvenido! ') }}{{ Auth::user()->name }}{{ __(' usted es administrador ') }}</div>

                    
                </div>
                <!-- usuarios_por_anio.blade.php -->
            </div>
            <div class="card" style="background-color: #333FF7">
                <div class="card-header text-center">
                    <h3 class="text-white">{{ __('¡Bienvenido!') }}</h3>
                </div>

                <div class="p-4 d-flex justify-content-center">
                    <img src="{{asset('imagenes/logo blanco.png')}}" class="" width="300" height="300">
                </div>

            </div>
            @elseif(Auth::user()->user_type===4)
            <div class="card">
                <div class="card-header text-center">{{ __('¡Bienvenid@ a INGECO líder de mesa, aquí podrá asignar artículos a los revisores y llevar el seguimiento!') }}</div>
                <div class="card-body">
                    <div class=" bg-light text-center">
                        <div class="d-flex justify-content-center">
                            <div class="col p-4" style="background-color: #2F16E4">
                                <!-- Logo -->
                                <div class="p-4">
                                    <img src="{{asset('imagenes/logo blanco.png')}}" class="" width="300" height="300">
                                </div>
                                <div class=" ">
                                    <p class="text-light font-bold" style="font-size: 200%">INGECO <span id="anio_actual"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(Auth::user()->user_type===2)
            <div class="card">
                <div class="card-header text-center">{{ __('Módulo de evaluación de artículos') }}</div>
                <div class="card-body">
                    <div class=" bg-light text-center">
                        <div class="d-flex justify-content-center">
                            <div class="col p-4" style="background-color: #2F16E4">
                                <!-- Logo -->
                                <div class="p-4">
                                    <img src="{{asset('imagenes/logo blanco.png')}}" class="" width="300" height="300">
                                </div>
                                <div class=" ">
                                    <p class="text-light font-bold" style="font-size: 200%">INGECO <span id="anio_actual"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="card" style="background-color: #333FF7">

                <div class="p-4 d-flex justify-content-center">
                    <img src="{{asset('imagenes/logo blanco.png')}}" class="" width="300" height="300">
                </div>

            </div>
            @endif

                <section class="features-icons bg-light text-center py-5 shadow-sm" style="border-radius: 15px;">
                    <div class="container">
                        <div class="row justify-content-center">

                            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                                <div class="features-icons-item mx-auto">
                                    <div class="features-icons-icon d-flex">
                                        <i class="bi bi-person-circle m-auto text-primary" style="font-size: 3rem;"></i>
                                    </div>
                                    <h3 class="mt-3">3a. Carta Derechos-FEGLININ</h3>
                                    <p class="lead mb-0">
                                        <a href="https://docs.google.com/document/d/1cj80rv-mUOe35Z1uo3DkdS-Ol7To1bqa/edit" target="_blank" class="btn btn-primary">
                                            Link para Descargar
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                                <div class="features-icons-item mx-auto">
                                    <div class="features-icons-icon d-flex">
                                        <i class="bi bi-book m-auto text-primary" style="font-size: 3rem;"></i>
                                    </div>
                                    <h3 class="mt-3">3b. Carta Derechos-RECIE</h3>
                                    <p class="lead mb-0">
                                        <a href="https://docs.google.com/document/d/1iEjBm4tDOTmAT4LpHvk1CTGMVCoJkZ6q/edit" target="_blank" class="btn btn-primary">
                                            Link para Descargar
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


        </div>
    </div>
</div>    



@endsection
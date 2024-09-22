@extends('layouts.app')

@section('content')
@if($usuario)
<div class="px-5 py-5 p-lg-0 bg-surface-secondary">
    <div class="d-flex justify-content-center">
        <div class="container-lg ">
            <div class="d-flex justify-content-start py-5">
                <a class="btn btn-primary" href="{{url('profileShow')}}"><i class="bi bi-box-arrow-left"></i> regresar</a>
            </div>

            <div class="row  rounded mr-4">
                <div class="mt-10 mt-lg-5 mb-6  align-items-center d-lg-block">
                    <h1 class="ls-tight font-bolder h2 text-center">
                        {{ __('Actualizar datos de perfil') }}
                    </h1>
                </div>
                <form action="{{url('/profileSaveEdit')}}" method="PUT">
                    @csrf
                    @method('PUT')

                    <div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-3">
                        <div class="mb-5 col">
                            <label class="form-label" for="name">{{ __('Nombre(s)') }}</label>
                            <input id="name" value="{{ $usuario->name }}" placeholder="Escriba su nombre" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-5 col">
                            <label class="form-label" for="ap_paterno">{{ __('Apellido paterno') }}</label>
                            <input id="ap_paterno" value="{{ $usuario->ap_paterno }}" placeholder="Escriba su apellido paterno" type="text" class="form-control @error('ap_paterno') is-invalid @enderror" name="ap_paterno" required autocomplete="ap_paterno" autofocus>

                            @error('ap_paterno')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-5 col">
                            <label class="form-label" for="ap_materno">{{ __('Apellido materno') }}</label>
                            <input id="ap_materno" value="{{ $usuario->ap_materno }}" placeholder="Escriba su apellido materno" type="text" class="form-control @error('ap_materno') is-invalid @enderror" name="ap_materno" required autocomplete="ap_materno" autofocus>

                            @error('ap_materno')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-5 col">
                            <label class="form-label" for="telefono">{{ __('Teléfono') }}</label>
                            <input id="telefono" value="{{ $usuario->telefono }}" placeholder="Escriba su telefono" type="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" required autocomplete="telefono" autofocus>

                            @error('telefono')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-5 col">
                            <label class="form-label" for="password">{{ __('Nueva Contraseña') }}</label>
                            <input id="password" placeholder="Escriba su nueva contraseña" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-5 col">
                            <label class="form-label" for="password_confirmation">{{ __('Confirmar Nueva Contraseña') }}</label>
                            <input id="password_confirmation" placeholder="Confirme su nueva contraseña" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="d-flex  justify-content-center py-4 row">
                        <button type="submit" role="button" class="btn btn-primary col-4"> Actualizar datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
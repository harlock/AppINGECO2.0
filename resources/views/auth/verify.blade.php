@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica tu correo') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Un link de verificacion se ha enviado a tu correo.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, verifica el mensaje enviado a tu correo por parte de AppIngeco.') }}
                    {{ __('Si no recibiste el correo') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('haz clic aquí para enviar otro enlace') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<x-guest-layout>
    <div class="px-5 py-5 p-lg-0 bg-surface-secondary ">
        <div class="d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <div class=" col-xl-4 p-12  position-fixed start-0 top-0 h-screen overflow-y-hidden bg-primary d-none d-lg-flex flex-column align-items-center">
                    <!-- Logo -->
                    <a class="d-block" href="#">
                        <img src="{{asset('imagenes/logo blanco.png')}}" class="" width="300" height="300">
                    </a>
                </div>
                <div class=" col-xl-15 offset-lg-4   d-flex flex-column justify-content-center py-lg-16 px-lg-20  ">
                    <div class="container-lg">
                    <a class="btn btn-primary" href="{{url('/')}}"><i class="bi bi-box-arrow-left"></i> Inicio</a>
                        <div class="row  rounded">
                            <div class="mt-10 mt-lg-5 mb-6  align-items-center d-lg-block">
                                <h1 class="ls-tight font-bolder h2 text-center">
                                    {{ __('Iniciar sesión') }}
                                </h1>
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-5">
                                    <label class="form-label" for="email">{{ __('Correo electrónico') }}</label>
                                    <input id="email" type="email" placeholder="Correo electrónico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-5">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <label class="form-label"  for="password">{{ __('Contraseña') }}</label>
                                        </div>
                                        {{--
                                        <div class="mb-2">
                                            @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="small text-muted">¿Olvidaste tu contraseña?</a>
                                            @endif
                                        </div>
                                        --}}
                                    </div>
                                    <input id="password" type="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Recordarme') }}
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary w-full">
                                        {{ __('Iniciar sesión') }}
                                    </button>
                                </div>
                            </form>
                            <div class="my-6">
                                <small>{{ __('¿No tienes una cuenta?') }}</small>
                                <a href="{{ route('register') }}" class="text-warning text-sm font-semibold">{{ __('Registrarme') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-guest-layout>

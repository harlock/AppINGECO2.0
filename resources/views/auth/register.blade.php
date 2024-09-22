<x-guest-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <div class="px-5 py-5 p-lg-0 bg-surface-secondary">
        <div class="d-flex justify-content-center">
            <div class=" col-xl-4 p-12  position-fixed start-0 top-0 h-screen overflow-y-hidden bg-primary d-none d-lg-flex flex-column align-items-center">
                <!-- Logo -->
                <a class="d-block" href="#">
                    <img src="{{asset('imagenes/logo blanco.png')}}" class="" width="300" height="300">
                </a>
                <!--
                <div class="mt-32 mb-20">
                    <h1 class="ls-tight font-bolder display-6 text-white mb-5">
                        Let’s build something amazing today.
                    </h1>
                    <p class="text-white-80">
                        Maybe some text here will help me see it better. Oh God. Oke, let’s do it then.
                    </p>
                </div>
-->
                <!-- Circle
                <div class="w-56 h-56 bg-orange-500 rounded-circle position-absolute bottom-0 end-20 transform translate-y-1/3"></div>
-->
            </div>
            <div class=" col-xl-15 offset-lg-4   d-flex flex-column justify-content-center py-lg-16 px-lg-20 ">
                <div class="container-lg">
                    <a class="btn btn-primary" href="/"><i class="bi bi-box-arrow-left"></i> Inicio</a>
                    <div class="row  rounded">
                        <div class="mt-10 mt-lg-5 mb-6  align-items-center d-lg-block">
                            <h1 class="ls-tight font-bolder h2 text-center">
                                {{ __('Crear una cuenta en INGECO') }}
                            </h1>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row row-cols-1 row-cols-lg-3 g-2 g-lg-3">
                                <div class="mb-5 col">
                                    <label class="form-label" for="name">{{ __('Nombre') }}</label>
                                    <input id="name" placeholder="Escriba su nombre" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-5 col">
                                    <label class="form-label" for="ap_paterno">{{ __('Apellido paterno') }}</label>
                                    <input id="ap_paterno" placeholder="Escriba su apellido paterno" type="text" class="form-control @error('ap_paterno') is-invalid @enderror" name="ap_paterno" value="{{ old('ap_paterno') }}" required autocomplete="ap_paterno" autofocus>

                                    @error('ap_paterno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-5 col">
                                    <label class="form-label" for="ap_materno">{{ __('Apellido materno') }}</label>
                                    <input id="ap_materno" placeholder="Escriba su apellido materno" type="text" class="form-control @error('ap_materno') is-invalid @enderror" name="ap_materno" value="{{ old('ap_materno') }}" required autocomplete="ap_materno" autofocus>

                                    @error('ap_materno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="mb-5 col">
                                    <label class="form-label" for="email">{{ __('Correo electrónico') }}</label>
                                    <input id="email" placeholder="Escriba su correo electrónico" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  value="{{ old('email') }}"required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-5 col">
                                    <label class="form-label" for="telefono">{{ __('Teléfono') }}</label>
                                    <input id="telefono" placeholder="Escriba su teléfono" type="telefono" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono" autofocus>

                                    @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="mb-5 col">
                                    <label class="form-label" for="password">{{ __('Contraseña') }}</label>
                                    <div class="input-group">
                                        <input id="password" placeholder="Escriba su contraseña" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="fa fa-eye" id="passwordIcon"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-5 col">
                                    <label class="form-label" for="password-confirm">{{ __('Confirmar contraseña') }}</label>
                                    <div class="input-group">
                                        <input id="password-confirm" placeholder="Confirmar contraseña" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                            <i class="fa fa-eye" id="confirmPasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const togglePassword = document.getElementById('togglePassword');
                                    const passwordInput = document.getElementById('password');
                                    const passwordIcon = document.getElementById('passwordIcon');

                                    togglePassword.addEventListener('click', function () {
                                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                        passwordInput.setAttribute('type', type);
                                        passwordIcon.classList.toggle('fa-eye');
                                        passwordIcon.classList.toggle('fa-eye-slash');
                                    });

                                    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
                                    const confirmPasswordInput = document.getElementById('password-confirm');
                                    const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');

                                    toggleConfirmPassword.addEventListener('click', function () {
                                        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                        confirmPasswordInput.setAttribute('type', type);
                                        confirmPasswordIcon.classList.toggle('fa-eye');
                                        confirmPasswordIcon.classList.toggle('fa-eye-slash');
                                    });
                                });
                            </script>

                            <div class="d-flex  justify-content-center py-4 row">
                                <button type="submit" class="btn btn-primary col-4">
                                    {{ __('Registrarme') }}
                                </button>
                            </div>

                        </form>
                        <div class="my-6">
                            <small>{{ __('¿Ya tienes una cuenta?') }}</small>
                            <a href="{{ route('login') }}" class="text-warning text-sm font-semibold">{{ __('Iniciar sesión') }}</a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</x-guest-layout>

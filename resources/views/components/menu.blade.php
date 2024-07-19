<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{-- config('app.name', 'Laravel') --}}

            <body onload="obtAnioActual()">
                <div>
                    INGECO
                    <span id="anio_actual"></span>
                </div>
            </body>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('home') }}">{{ __('Inicio') }}</a>
                </li>
                @if(Auth::user()->user_type==1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home.users') }}">{{ __('Validar Usuarios') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('usuarios') }}">Asignar Líderes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('revisores') }}">Asignar Revisores</a>
                </li>
                <li class="nav-item">
                    <a href="{{url('mesas')}}" class="nav-link">Mesas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('artAdministrador') }}">{{ __('Artículos ') }}</a>
                </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('periodos.create') }}">Añadir Nuevo Periodo</a>
                        </li>

                    @endif

                @if(Auth::user()->user_type==4)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('lideres') }}">Asignar Revisor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vista.artic.rev') }}">Seguimiento de artículos</a>
                </li>
                @endif
                    @if(Auth::user()->user_type == 3)
                        @if ($periodoActivo)
                            <li class="nav-item">
                                <a href="{{ url('enviar_articulo/create') }}" class="nav-link">Enviar Artículos</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <span class="nav-link disabled">Enviar Artículos</span>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('show.art') }}" class="nav-link">Artículos Enviados</a>
                        </li>
                    @endif
                @if(Auth::user()->user_type==2)
                <li class="nav-item">
                    <a href="{{url('evaluar_art')}}" class="nav-link">Evaluar Artículos</a>
                </li>
                @endif


                <!-- Menu de usuario-->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdown">
                        <a href="{{url('profileShow')}}" role="button" class="btn btn-sm btn-outline-primary d-flex justify-content-center "><i class="bi bi-eye "></i> Perfil</a>
                        <a class="dropdown-item d-flex justify-content-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Salir') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @else
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                </li>
                @endif
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                </li>
                @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
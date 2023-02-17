<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <input id="url-base" type="hidden" value="{{ config('app.url') }}">
    <input id="url-cep" type="hidden" value="{{ config('app.bcode_ceps') }}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
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
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active':'' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  Cadastros
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a 
                                            class="dropdown-item {{ request()->routeIs('cadastro.cliente.index') ? 'active':'' }}" 
                                            href="{{ route('cadastro.cliente.index') }}"
                                        >
                                            {{ __('Clientes') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            class="dropdown-item {{ request()->routeIs('cadastro.reguladora.index') ? 'active':'' }}" 
                                            href="{{ route('cadastro.reguladora.index') }}"
                                        >
                                            {{ __('Reguladoras') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            class="dropdown-item {{ request()->routeIs('cadastro.seguradora.index') ? 'active':'' }}" 
                                            href="{{ route('cadastro.seguradora.index') }}"
                                        >
                                            {{ __('Seguradoras') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            class="dropdown-item {{ request()->routeIs('cadastro.tipo-despesa.index') ? 'active':'' }}" 
                                            href="{{ route('cadastro.tipo-despesa.index') }}"
                                        >
                                            {{ __('Tipo de despesas') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            class="dropdown-item {{ request()->routeIs('cadastro.tipo-servico.index') ? 'active':'' }}" 
                                            href="{{ route('cadastro.tipo-servico.index') }}"
                                        >
                                            {{ __('Tipo de serviços') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            class="dropdown-item {{ request()->routeIs('register') ? 'active':'' }}" 
                                            href="{{ route('register') }}"
                                        >
                                            {{ __('Usuários') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script type="module">
        @if (session('success'))
            swal("Ok!", "{!! session('success') !!}", "success");
        @endif
        new DataTable('.datatable', {
            language: {
                lengthMenu: 'Exibir registros _MENU_ por página',
                zeroRecords: 'Nenhum registro encontrado!',
                info: 'Mostrando a página _PAGE_ de _PAGES_',
                infoEmpty: 'Não há registros disponíveis',
                infoFiltered: '(filtrado do total de registros _MAX_)',
                sSearch: 'Pesquisar',
                oPaginate: {
                    sNext:"Próximo",
                    sPrevious:"Anterior"
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    @yield('scripts')
</body>
</html>

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
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="img-logo" src="{{ url('/') }}/img/logo-site.png" alt="{{ config('app.name', 'Laravel') }}" />
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
                                    <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> {{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active':'' }}" href="{{ route('home') }}">
                                    <i class="fa-solid fa-house"></i> {{ __('Home') }}
                                </a>
                            </li>
                            @can('cadastros')
                                <li class="nav-item dropdown">
                                    <a class=" nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-file-circle-plus"></i> Cadastros
                                    </a>
                                    <ul class="dropdown-menu">
                                        @can('cadastro-cliente')
                                            <li>
                                                <a
                                                    class="dropdown-item {{ request()->routeIs('cadastro.cliente.index') ? 'active':'' }}"
                                                    href="{{ route('cadastro.cliente.index') }}"
                                                >
                                                    <i class="fa-solid fa-user-tie"></i> {{ __('Clientes') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('cadastro-grupo-permissao')
                                            <li>
                                                <a
                                                    class="dropdown-item {{ request()->routeIs('cadastro.grupo-permissao.index') ? 'active':'' }}"
                                                    href="{{ route('cadastro.grupo-permissao.index') }}"
                                                >
                                                    <i class="fa-solid fa-lock"></i> {{ __('Grupo de Permissões') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('cadastro-reguladora')
                                            <li>
                                                <a
                                                    class="dropdown-item {{ request()->routeIs('cadastro.reguladora.index') ? 'active':'' }}"
                                                    href="{{ route('cadastro.reguladora.index') }}"
                                                >
                                                    <i class="fa-solid fa-pen-ruler"></i> {{ __('Reguladoras') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('cadastro-seguradora')
                                            <li>
                                                <a
                                                    class="dropdown-item {{ request()->routeIs('cadastro.seguradora.index') ? 'active':'' }}"
                                                    href="{{ route('cadastro.seguradora.index') }}"
                                                >
                                                    <i class="fa-solid fa-shield-halved"></i> {{ __('Seguradoras') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('cadastro-tipo-despesa')
                                            <li>
                                                <a
                                                    class="dropdown-item {{ request()->routeIs('cadastro.tipo-despesa.index') ? 'active':'' }}"
                                                    href="{{ route('cadastro.tipo-despesa.index') }}"
                                                >
                                                    <i class="fa-solid fa-file-invoice-dollar"></i> {{ __('Tipo de despesas') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('cadastro-tipo-servico')
                                            <li>
                                                <a
                                                    class="dropdown-item {{ request()->routeIs('cadastro.tipo-servico.index') ? 'active':'' }}"
                                                    href="{{ route('cadastro.tipo-servico.index') }}"
                                                >
                                                    <i class="fa-solid fa-screwdriver-wrench"></i> {{ __('Tipo de serviços') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('cadastro-usuario')
                                            <li>
                                                <a
                                                    class="dropdown-item {{ request()->routeIs('cadastro.usuario.index') ? 'active':'' }}"
                                                    href="{{ route('cadastro.usuario.index') }}"
                                                >
                                                    <i class="fa-solid fa-user-group"></i> {{ __('Usuários') }}
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan

                            <li class="nav-item  dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }} <i class="fa-solid fa-right-from-bracket"></i>
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
                lengthMenu: 'Exibir _MENU_ por página',
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

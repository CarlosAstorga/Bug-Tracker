<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bug Tracker</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/toggle.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

    <style>
        body {
            background-color: #F0F0F0;
        }

        #wrapper {
            overflow-x: hidden;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            -webkit-transition: margin .25s ease-out;
            -moz-transition: margin .25s ease-out;
            -o-transition: margin .25s ease-out;
            transition: margin .25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        .avatar {
            vertical-align: middle;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }
    </style>
    @yield('css')
</head>

<body>
    <div class="d-flex @if(@session('toggled')) toggled @endif" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Bug Tracker </div>
            <div class="list-group list-group-flush">
                <a href="{{ url('/home') }}" class="list-group-item list-group-item-action"><i class="fas fa-chart-line mr-2"></i> Dashboard</a>
                @can('manage-users')
                <a href="{{route('admin.users.index')}}" class="list-group-item list-group-item-action"><i class="fas fa-users mr-2"></i> Usuarios</a>
                @endcan

                @can('manage-projects')
                <a href="{{route('projects.index')}}" class="list-group-item list-group-item-action"><i class="fas fa-project-diagram mr-2"></i> Proyectos</a>
                @endcan
                <a href="{{route('tickets.index')}}" class="list-group-item list-group-item-action"><i class="fas fa-tasks mr-2"></i> Tickets</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">

                <button id="menu-toggle" class="navbar-toggler" type="button" style="display: contents;">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="avatar" src="/images/{{auth()->user()->avatar}}" alt="avatar">
                                &nbsp;{{auth()->user()->name}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">Mi perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endauth
                    </ul>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    @yield('scripts')
</body>

</html>
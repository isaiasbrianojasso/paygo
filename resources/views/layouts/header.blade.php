@php
$url = url('/');
$current = url()->current();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="SMS Panel" />
    <meta name="author" content="hollydev" />

    <!-- Fuentes y estilos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Tema propio -->
    <link href="/assets/css/vendor.min.css" rel="stylesheet" />
    <link href="/assets/css/material/app.min.css" rel="stylesheet" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Componente Blade si aplica -->

    <style>
        body,
        .menu-text,
        h1, h2, h3, h4, h5, h6,
        p, th, td, div, button, input, label {
            font-family: "Roboto Slab", serif;
            font-size: 14px;
            font-weight: 400;
            color: #555;
        }
        input[type="file"] {
    display: block;
    pointer-events: auto;
    z-index: 1000;
}
        .app-loader {
            background-color: #f8f9fa;
        }
        .app-loader .message {
            color: #6c757d;
        }
    </style>
</head>

<body class='pace-top ' oncontextmenu="return false;" onselectstart="return false;" ondragstart="return false;">
    <!-- BEGIN #loader -->
    <div id="loader" class="app-loader">
        <div class="material-loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10">
                </circle>
            </svg>
            <div class="message">Loading...</div>
        </div>
    </div>
    <!-- END #loader -->

    <!-- BEGIN #app -->
    <div id="app" class=" app app-header-fixed app-sidebar-fixed app-content-full-height app-with-wide-sidebar">
        <!-- BEGIN #header -->
        <div id="header" class="app-header ">
            <!-- BEGIN navbar-header -->
            <div class="navbar-header">
                <a href="/home" class="navbar-brand ">Trust us ... </a>
                <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- END navbar-header -->

            <!-- BEGIN header-nav -->
            <div class="navbar-nav">

                <div class="nav-item dropdown">
                    <!-- Puedes agregar aquí otros elementos de dropdown si lo necesitas -->
                </div>
                <div class="nav-item dropdown navbar-user">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                        <img src="/assets/img/user/user-14.jpg" alt="" />
                        <span>
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            <b class="caret"></b>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end me-1">
                        <li>
                            <a href="user/profile" class="dropdown-item">Perfil</a>
                        </li>
                        <li>
                            <a href="/apiserviceshistorial" class="dropdown-item">
                                <div class="menu-text">Services Subscripted</div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="document.getElementById('logout').submit();" class="dropdown-item">Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END header-nav -->


        </div>
        <!-- END #header -->


        <x-sidebar></x-sidebar>

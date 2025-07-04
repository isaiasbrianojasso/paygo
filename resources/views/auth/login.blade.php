@php
$url = url()->current();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- CSRF Token -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- ================== BEGIN core-css ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="/assets/css/vendor.min.css" rel="stylesheet" />
    <link href="/assets/css/material/app.min.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ================== END core-css ================== -->
</head>

<body class='pace-top'>
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
    <div id="app" class="app">
        <!-- BEGIN login -->
        <div class="login login-v2 fw-bold">
            <!-- BEGIN login-cover -->
            <div class="login-cover">
                <div class="login-cover-img" style="background-image: url(/assets/img/paygo.png)"
                    data-id="login-cover-image"></div>
                <div class="login-cover-bg"></div>
            </div>
            <!-- END login-cover -->

            <!-- BEGIN login-container -->
            <div class="login-container">
                <!-- BEGIN login-header -->
                <div class="login-header">
                    <div class="brand">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-comment-sms"> &nbsp;</i> {{ config('app.name') }}
                        </div>
                        <small>{{ config('app.name') }} Es La Mejor Mensajeria Que Puedas Usar</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-person"></i>
                    </div>
                </div>
                <!-- END login-header -->

                <!-- BEGIN login-content -->
                <div class="login-content">
                    <form action="{{$url }}" method="POST">
                        @csrf
                        <div class="form-floating mb-20px">
                            <input type="text" name="email" class="form-control fs-13px h-45px border-0"
                                placeholder="Email Address" id="emailAddress" />
                            <label for="emailAddress" class="d-flex align-items-center text-gray-600 fs-13px">Email
                                Address</label>
                        </div>
                        <div class="form-floating mb-20px">
                            <input type="password" name="password" class="form-control fs-13px h-45px border-0"
                                placeholder="Password" />
                            <label for="emailAddress"
                                class="d-flex align-items-center text-gray-600 fs-13px">Password</label>
                        </div>

                        <div class="mb-20px">
                            <button type="submit" class="btn btn-cyan d-block w-100 h-45px btn-lg">Iniciar
                                Sesion</button>
                        </div>
                    </form>
                </div>
                <!-- END login-content -->
            </div>
            <!-- END login-container -->
        </div>
        <!-- END login -->
        @include('footer')

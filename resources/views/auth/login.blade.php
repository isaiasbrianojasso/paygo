@php
$url = url()->current();
if (request()->routeIs('login')) {
    $url = route('login');
} elseif (request()->routeIs('register')) {
    $url = route('register');
}
if (request()->routeIs('password.request')) {
    $url = route('password.request');
} elseif (request()->routeIs('password.reset')) {
    $url = route('password.reset');
}
if (request()->routeIs('passkey.register')) {
    $url = route('passkey.register');
} elseif (request()->routeIs('passkey.verify')) {
    $url = route('passkey.verify');
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
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
                <div class="login-cover-img" style="background-image: url(/assets/img/login.png)"
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
                            <img src="/assets/img/paygo.png" alt="Logo" class="img-fluid me-2"
                                style="max-height: 200px;">
                        </div>
                        <small> Confia en nosotros ,validamos tus pagos por ti </small>
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

                            <button type="submit" class="btn btn-primary d-block w-100 h-45px btn-lg mb-5">Iniciar
                                Sesion</button>

                            <button id="register-passkey"
                                class="btn btn-secondary d-block w-100 h-45px btn-lg mt-5">Registrar Passkey</button>

                        </div>
                    </form>
                </div>
                <!-- END login-content -->
            </div>
            <!-- END login-container -->
        </div>
        <!-- END login -->
        <!-- BEGIN scroll-top-btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        <!-- END scroll-top-btn -->
        <div class="card-footer text-center text-muted small">
            This service is powered by <strong>paygo.blog</strong> — All rights reserved © {{ date('Y') }}
        </div>
    </div>
    <script>
        const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    const options = await fetch('/passkey/options', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ username: email.value, password: password.value })
}).then(r => r.json());

const credential = await navigator.credentials.create({ publicKey: options });

await fetch('/passkey/verify', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(credential)
});

    </script>
    <!-- END #app -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ================== BEGIN core-js ================== -->
    <script src="/assets/js/vendor.min.js"></script>
    <script src="/assets/js/app.min.js"></script>
    <!-- ================== END core-js ================== -->

    <!-- ================== BEGIN page-js ================== -->
    <script src="/assets/js/demo/login-v2.demo.js"></script>
    <!-- ================== END page-js ================== -->

<?php
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} - Register</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="PayGo" name="description" />
    <meta content="HollyDev" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSRF Token -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- ================== BEGIN core-css ================== -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --paygo-blue: #003087;
            --paygo-lightblue: #009cde;
            --paygo-darkblue: #001a4d;
            --paygo-white: #f5f7fa;
            --paygo-gray: #e6e9ed;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--paygo-white);
            color: #2c3e50;
        }

        .login-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 450px;
            margin: 40px auto;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand {
            color: var(--paygo-blue);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .brand small {
            color: #666;
            font-weight: 400;
            font-size: 14px;
        }

        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: var(--paygo-lightblue);
            box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.1);
        }

        .btn-paygo {
            background-color: var(--paygo-blue);
            color: white;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 600;
            border: none;
            height: 50px;
            width: 100%;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-paygo:hover {
            background-color: var(--paygo-darkblue);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: white;
            color: var(--paygo-blue);
            border: 2px solid var(--paygo-blue);
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 600;
            height: 50px;
            width: 100%;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--paygo-blue);
            color: white;
        }

        .login-cover {
            background: linear-gradient(135deg, var(--paygo-blue) 0%, var(--paygo-lightblue) 100%);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }

        .login-cover-img {
            opacity: 0.2;
            background-size: cover;
            background-position: center;
        }

        .login-cover-bg {
            background-color: rgba(0, 0, 0, 0.3);
        }

        .card-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--paygo-darkblue);
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 14px;
        }

        .card-footer strong {
            color: var(--paygo-lightblue);
        }

        .material-loader {
            color: var(--paygo-blue);
        }

        .text-danger {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        .terms-link {
            color: var(--paygo-blue);
            text-decoration: none;
            font-weight: 500;
        }

        .terms-link:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class='pace-top'>
    <div id="app" class="app">
        <!-- BEGIN login-cover -->
        <div class="login-cover">
            <div class="login-cover-img" style="background-image: url(/assets/img/login.png)"
                data-id="login-cover-image"></div>
            <div class="login-cover-bg"></div>
        </div>
        <!-- END login-cover -->

        <!-- BEGIN login-container -->
        <div class="login-container" data-aos="fade-in">
            <!-- BEGIN login-header -->
            <div class="login-header">
                <div class="brand">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="/assets/img/paygo.png" alt="Logo" class="img-fluid" style="max-height: 80px;">
                    </div>
                    <small>Confía en nosotros, validamos tus pagos por ti</small>
                </div>
            </div>
            <!-- END login-header -->

            <!-- BEGIN login-content -->
            <div class="login-content">
                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="mb-4">
                    @foreach ($errors->all() as $error)
                    <div class="text-danger">{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" id="name"
                            value="{{ old('name') }}" required autofocus />
                        <label for="name">Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" id="email"
                            value="{{ old('email') }}" required />
                        <label for="email">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password"
                            required autocomplete="new-password" />
                        <label for="password">Password</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password" id="password_confirmation" required />
                        <label for="password_confirmation">Confirm Password</label>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'"
                                    class="terms-link">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'"
                                    class="terms-link">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </label>
                        </div>
                    </div>
                    @endif

                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-paygo">Register</button>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--paygo-blue);">
                            Already registered? Login here
                        </a>
                    </div>
                </form>
            </div>
            <!-- END login-content -->
        </div>
        <!-- END login-container -->

        <div class="card-footer">
            This service is powered by <strong>paygo.blog</strong> — All rights reserved © {{ date('Y') }}
        </div>
    </div>
    <!-- END #app -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 500,
            once: true
        });
    </script>
</body>

</html>

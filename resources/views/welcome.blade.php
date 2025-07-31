<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayGo – {{ __('Bienvenido') }}</title>

    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f9fc;
        }

        .brand {
            color: #0070ba;
            font-weight: bold;
        }

        .btn-paygo {
            background-color: #0070ba;
            color: #fff;
            border-radius: 10px;
        }

        .btn-paygo:hover {
            background-color: #005ea3;
        }

        footer {
            background-color: #e9ecef;
            padding: 20px 0;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* WhatsApp floating button */
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }

        .whatsapp-float a {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #25d366;
            color: #fff;
            font-size: 24px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            transition: background 0.3s ease;
        }

        .whatsapp-float a:hover {
            background: #1ebe5d;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="display-4 brand">PayGo</h1>
            <p class="lead">{{ __('Tu forma segura, rápida y confiable de mover dinero.') }}</p>

            {{-- Botones --}}
            <div class="d-grid gap-2 d-sm-flex justify-content-center mt-4">
                <a href="{{ route('login') }}" class="btn btn-paygo btn-lg px-5">{{ __('Iniciar sesión') }}</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5">{{ __('Crear cuenta')
                    }}</a>
            </div>

            {{-- Selector de idioma --}}
            <div class="mt-3">
                <a href="{{ url('locale/es') }}" class="me-2">🇲🇽 Español</a> |
                <a href="{{ url('locale/en') }}">🇺🇸 English</a>
            </div>
        </div>

        {{-- Video Promocional --}}
        <div class="video-container mb-5" data-aos="zoom-in">
            <iframe src="https://www.youtube.com/embed/ScMzIvxBSi4" frameborder="0" allowfullscreen></iframe>
        </div>

        {{-- Beneficios --}}
        <div class="row text-center mb-5" data-aos="fade-up">
            <div class="col-md-4 mb-3">
                <i class="fa fa-lock fa-2x text-primary mb-2"></i>
                <h5>{{ __('Seguridad') }}</h5>
                <p>{{ __('Protección con tecnología de nivel bancario.') }}</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fa fa-clock fa-2x text-primary mb-2"></i>
                <h5>{{ __('Velocidad') }}</h5>
                <p>{{ __('Transfiere al instante, sin complicaciones.') }}</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fa fa-globe fa-2x text-primary mb-2"></i>
                <h5>{{ __('Internacional') }}</h5>
                <p>{{ __('Envíos y pagos en múltiples monedas.') }}</p>
            </div>
        </div>

        {{-- Testimonios --}}
        <div class="row text-center mt-5" data-aos="fade-up" data-aos-delay="200">
            <h3 class="mb-4">{{ __('Lo que dicen nuestros usuarios') }}</h3>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"{{ __('Rápido y fácil, me salvó varias veces.') }}"</p>
                    <footer class="blockquote-footer">Luis M. – Mérida</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"{{ __('El sistema más simple para cobrarle a mis clientes.') }}"</p>
                    <footer class="blockquote-footer">Ana R. – Tijuana</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"{{ __('Mejor que cualquier banco, sin duda.') }}"</p>
                    <footer class="blockquote-footer">Sergio G. – Puebla</footer>
                </blockquote>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="text-center text-muted mt-5">
        <div class="container">
            <p class="mb-1">&copy; {{ date('Y') }} PayGo. {{ __('Todos los derechos reservados.') }}</p>
            <small>
                <a href="#">{{ __('Términos de uso') }}</a> ·
                <a href="#">{{ __('Privacidad') }}</a> ·
                <a href="#">{{ __('Soporte') }}</a>
            </small>
        </div>
    </footer>

    {{-- Botón flotante WhatsApp --}}
    <div class="whatsapp-float">
        <a href="https://wa.me/5214441234567" target="_blank" title="Soporte por WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>

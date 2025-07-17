<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a PayGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f6f8fa;
        }

        .brand {
            color: #0070ba;
            font-weight: bold;
        }

        .btn-paygo {
            background-color: #0070ba;
            color: white;
            font-weight: 500;
            border-radius: 10px;
        }

        .btn-paygo:hover {
            background-color: #005ea3;
        }

        footer {
            background-color: #e9ecef;
            padding: 20px 0;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 brand">PayGo</h1>
            <p class="lead">Tu forma segura, rápida y confiable de mover dinero.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-center mt-4">
                <a href="{{ route('login') }}" class="btn btn-paygo btn-lg px-5">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5">Crear cuenta</a>
            </div>
        </div>
<hr>
        {{-- Beneficios --}}
        <div class="row text-center mb-5" data-aos="fade-up" data-aos-delay="200">
            <div class="col-md-4 mb-4">
                <i class="fa fa-shield-alt fa-2x text-primary mb-2"></i>
                <h5>Seguridad</h5>
                <p>Protegemos cada transacción con tecnología de encriptado de nivel bancario.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fa fa-bolt fa-2x text-primary mb-2"></i>
                <h5>Velocidad</h5>
                <p>Envía y recibe dinero en segundos, sin complicaciones.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fa fa-mobile-alt fa-2x text-primary mb-2"></i>
                <h5>Accesibilidad</h5>
                <p>Administra tu dinero desde cualquier lugar con tu celular.</p>
            </div>
        </div>

        {{-- Testimonios --}}
        <div class="row text-center mt-5" data-aos="fade-up" data-aos-delay="400">
            <h3 class="mb-4">Lo que dicen nuestros usuarios</h3>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"PayGo me salvó en una emergencia. Dinero al instante."</p>
                    <footer class="blockquote-footer">Laura G. – CDMX</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"Mucho más rápido y claro que los bancos tradicionales."</p>
                    <footer class="blockquote-footer">Carlos R. – Guadalajara</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p>"Perfecto para enviar pagos a clientes, sin comisiones ocultas."</p>
                    <footer class="blockquote-footer">María T. – Monterrey</footer>
                </blockquote>
            </div>
        </div>
    </div>
<hr>
    {{-- Footer --}}
    <footer class="text-center text-muted">
        <div class="container">
            <p class="mb-1">&copy; {{ date('Y') }} PayGo. Todos los derechos reservados.</p>
            <small>
                <a href="#">Términos de uso</a> ·
                <a href="#">Privacidad</a> ·
                <a href="#">Soporte</a>
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>

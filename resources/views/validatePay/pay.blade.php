<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Título -->
            <div class="mb-4 text-center">
                <h2 class="fw-bold">Pago Automático</h2>
                <p class="text-muted">Transacción segura</p>
            </div>

            <!-- Stepper -->
            <div class="mb-5 stepper-wrapper">
                <div class="stepper-item completed">
                    <div class="step-counter">1</div>
                    <div class="step-name">Datos</div>
                </div>
                <div class="stepper-item active">
                    <div class="step-counter">2</div>
                    <div class="step-name">Escanear</div>
                </div>
                <div class="stepper-item">
                    <div class="step-counter">3</div>
                    <div class="step-name">Comprobante</div>
                </div>
            </div>

            <!-- Card principal -->
            <div class="card shadow-sm">
                <div class="card-header text-center bg-white border-bottom">
                    <h5 class="mb-0">Resumen del pago</h5>
                </div>
                <div class="card-body p-4">

                    <!-- Paso 1: Escanear QR -->
                    <div class="payment-step" id="step1">
                        <div class="mb-4 text-center">
                            <h5 class="mb-3 fw-bold">Escanea el código QR</h5>
                            <p class="text-muted">Usa la aplicación de tu banco o billetera digital</p>
                            <div class="qr-container">
                                <img src="/assets/img/zeta.jpeg" alt="QR de pago"
                                    style="width: 220px; height: 220px;"
                                    onerror="this.onerror=null;this.src='https://via.placeholder.com/220?text=QR+no+disponible';">
                            </div>

                            <div class="p-3 mt-4 rounded" style="background-color: #f8f9fa;">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Monto:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="amount" placeholder="0.00" step="0.01" min="0" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label text-muted">Correo electrónico del servidor para acreditar pago:</label>
                                    <input type="email" class="form-control" id="email" placeholder="tu@email.com" required>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary-custom w-100 py-2 fw-bold next-step">
                            Ya pagué <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Paso 2: Datos del pago -->
                    <div class="payment-step d-none" id="step2">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Orden ID (ID de pago en la captura de pantalla)</label>
                            <input type="text" class="form-control" id="concept" placeholder="Ej. Servicio Premium">
                        </div>
                        <div class="mt-4 d-flex justify-content-between">
                            <button class="btn btn-outline-secondary prev-step">
                                <i class="bi bi-arrow-left"></i> Atrás
                            </button>
                            <button class="btn btn-primary-custom next-step">
                                Continuar <i class="bi bi-check-circle"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Paso 3: Subir comprobante -->
                    <div class="payment-step d-none" id="step3">
                        <div class="mb-4 text-center">
                            <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: orange;"></i>
                            <h5 class="mt-3 fw-bold">¡Pago en revisión!</h5>
                            <p class="text-muted">Por favor sube tu comprobante para completar el proceso</p>
                        </div>
                        <form id="paymentForm" action="{{ route('zeta') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="amount" id="form-amount">
                            <input type="hidden" name="email" id="form-email">
                            <input type="hidden" name="concept" id="form-concept">
                            <input type="hidden" name="api_key" value="{{ $api_key }}">

                            <div class="mb-4 file-upload-area text-center p-5">
                                <input type="file" class="d-none" id="screenshot" name="screenshot" accept="image/*" required>
                                <label for="screenshot" class="mb-3 btn btn-outline-primary">
                                    <i class="bi bi-cloud-arrow-up"></i> Seleccionar archivo
                                </label>
                                <p class="small text-muted">Formatos aceptados: JPG, PNG (Máx. 5MB)</p>
                                <div id="file-name" class="mt-2 small"></div>
                            </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary prev-step">
                                    <i class="bi bi-arrow-left"></i> Atrás
                                </button>
                                <button type="submit" class="btn btn-primary-custom">
                                    Enviar comprobante <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="mt-4 text-center">
                <p class="secure-text">
                    <i class="bi bi-lock-fill"></i> Tu información está protegida con encriptación SSL
                </p>
                <div class="d-flex justify-content-center align-items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/Binance_Logo.png" alt="Binance" height="30">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos mejorados -->
<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }
    h2, h5 {
        color: #003087;
    }
    .card {
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: none;
    }
    /* Stepper */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }
    .stepper-item {
        position: relative;
        flex: 1;
        text-align: center;
    }
    .stepper-item::before {
        content: "";
        position: absolute;
        top: 20px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #dee2e6;
        z-index: 1;
    }
    .stepper-item:first-child::before {
        display: none;
    }
    .step-counter {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #dee2e6;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-weight: bold;
        font-size: 1rem;
        z-index: 2;
    }
    .stepper-item.active .step-counter {
        background-color: #003087;
        color: white;
        box-shadow: 0 0 0 4px rgba(0, 48, 135, 0.2);
    }
    .stepper-item.completed .step-counter {
        background-color: #28a745;
        color: white;
    }
    .step-name {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .stepper-item.active .step-name {
        color: #003087;
        font-weight: 600;
    }
    /* Inputs y botones */
    .form-control, .input-group-text {
        border-radius: 8px;
    }
    .btn {
        border-radius: 8px;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-primary-custom {
        background-color: #003087;
        color: white;
        border: none;
    }
    .btn-primary-custom:hover {
        background-color: #00205c;
    }
    .btn-outline-secondary:hover {
        background-color: #f0f0f0;
    }
    /* Área de carga */
    .file-upload-area {
        background-color: #f8f9fa;
        border: 2px dashed #d1dbe3;
        border-radius: 12px;
        transition: all 0.3s;
        cursor: pointer;
    }
    .file-upload-area:hover {
        border-color: #003087;
        background-color: #f0f7ff;
    }
    /* QR */
    .qr-container {
        padding: 1rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: inline-block;
    }
    /* Footer */
    .secure-text {
        font-size: 0.85rem;
        color: #6c757d;
    }
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.payment-step');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');

    steps[0].classList.remove('d-none');

    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentStep = this.closest('.payment-step');
            const nextStepId = parseInt(currentStep.id.replace('step', '')) + 1;
            if (nextStepId <= 3) {
                currentStep.classList.add('d-none');
                document.getElementById(`step${nextStepId}`).classList.remove('d-none');
                updateStepper(nextStepId);
                if (nextStepId === 2) {
                    document.getElementById('form-amount').value = document.getElementById('amount').value;
                    document.getElementById('form-email').value = document.getElementById('email').value;
                    document.getElementById('form-concept').value = document.getElementById('concept').value;
                }
            }
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentStep = this.closest('.payment-step');
            const prevStepId = parseInt(currentStep.id.replace('step', '')) - 1;
            if (prevStepId >= 1) {
                currentStep.classList.add('d-none');
                document.getElementById(`step${prevStepId}`).classList.remove('d-none');
                updateStepper(prevStepId);
            }
        });
    });

    function updateStepper(activeStep) {
        document.querySelectorAll('.stepper-item').forEach((item, index) => {
            item.classList.remove('active', 'completed');
            if (index + 1 < activeStep) {
                item.classList.add('completed');
            } else if (index + 1 === activeStep) {
                item.classList.add('active');
            }
        });
    }

    document.getElementById('screenshot').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
        document.getElementById('file-name').textContent = fileName;
    });

    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.success ? 'success' : 'error',
                title: data.success ? '¡Comprobante enviado!' : 'Error',
                text: data.success ? 'Tu pago está siendo verificado' : 'Hubo un problema al enviar el comprobante',
                confirmButtonColor: '#003087'
            });
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al enviar el comprobante',
                confirmButtonColor: '#003087'
            });
        });
    });
});
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color: #003087;">Pago Automático</h2>
                <p class="text-muted">Transacción segura</p>
            </div>
            <!-- Indicador de pasos -->
            <div class="stepper-wrapper mb-5">
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
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom" style="background-color: #f5f7fa;">
                    <h5 class="mb-0 text-center" style="color: #003087;">Resumen del pago</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Paso 1: Datos del pago -->
                    <div class="payment-step" id="step1">
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #003087;">Monto a pagar</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="amount" placeholder="0.00" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #003087;">Correo electrónico del Server</label>
                            <input type="email" class="form-control" id="email" placeholder="tu@email.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #003087;">Concepto del pago</label>
                            <input type="text" class="form-control" id="concept" placeholder="Ej. Servicio Premium">
                        </div>
                        <button class="btn w-100 py-2 fw-bold next-step" style="background-color: #003087; color: white;">
                            Continuar <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                    <!-- Paso 2: Escanear QR -->
                    <div class="payment-step d-none" id="step2">
                        <div class="text-center mb-4">
                            <h5 class="fw-bold mb-3" style="color: #003087;">Escanea el código QR</h5>
                            <p class="text-muted">Usa la aplicación de tu banco o billetera digital</p>
                            <div class="p-3 bg-white rounded d-inline-block border mt-3">
                                <img src="/assets/img/zeta.jpeg" alt="QR de pago Zeta" style="width: 220px; height: 220px;">
                            </div>
                            <div class="mt-4 p-3 rounded" style="background-color: #f8f9fa;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Monto:</span>
                                    <span class="fw-bold" id="display-amount">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Destinatario:</span>
                                    <span class="fw-bold" id="display-email">test@example.com</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button class="btn btn-outline-secondary prev-step">
                                <i class="bi bi-arrow-left"></i> Atrás
                            </button>
                            <button class="btn next-step" style="background-color: #003087; color: white;">
                                Ya pagué <i class="bi bi-check-circle"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Paso 3: Subir comprobante -->
                    <div class="payment-step d-none" id="step3">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: orange;"></i>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: #003087;">¡Pago en revisión!</h5>
                            <p class="text-muted">Por favor sube tu comprobante para completar el proceso</p>
                        </div>
                        <form id="paymentForm" action="{{ route('zeta') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="amount" id="form-amount">
                            <input type="hidden" name="email" id="form-email">
                            <input type="hidden" name="concept" id="form-concept">
                            <div class="mb-4">
                                <div class="file-upload-area border rounded p-5 text-center">
                                    <input type="file" class="d-none" id="screenshot" name="screenshot" accept="image/*" required>
                                    <label for="screenshot" class="btn btn-outline-primary mb-3">
                                        <i class="bi bi-cloud-arrow-up"></i> Seleccionar archivo
                                    </label>
                                    <p class="small text-muted mb-0">Formatos aceptados: JPG, PNG (Máx. 5MB)</p>
                                    <div id="file-name" class="mt-2 small"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary prev-step">
                                    <i class="bi bi-arrow-left"></i> Atrás
                                </button>
                                <button type="submit" class="btn" style="background-color: #003087; color: white;">
                                    Enviar comprobante <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="small text-muted">
                    <i class="bi bi-lock-fill"></i> Tu información está protegida con encriptación SSL
                </p>
                <div class="d-flex justify-content-center align-items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/Binance_Logo.png" alt="Binance" height="30">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos personalizados */
    body {
        background-color: #f5f7fa;
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }

    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .stepper-item {
        position: relative;
        flex: 1;
        text-align: center;
    }

    .stepper-item::before {
        content: "";
        position: absolute;
        top: 15px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #dee2e6;
        z-index: 1;
    }

    .stepper-item.completed::before {
        background-color: #003087;
    }

    .stepper-item:first-child::before {
        display: none;
    }

    .step-counter {
        position: relative;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #dee2e6;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 5px;
        z-index: 2;
    }

    .stepper-item.active .step-counter {
        background-color: #003087;
        color: white;
    }

    .stepper-item.completed .step-counter {
        background-color: #28a745;
        color: white;
    }

    .step-name {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .stepper-item.active .step-name {
        color: #003087;
        font-weight: 500;
    }

    .file-upload-area {
        background-color: #f8f9fa;
        border: 2px dashed #d1dbe3;
        transition: all 0.3s;
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: #003087;
        background-color: #f0f7ff;
    }

    .payment-card {
        border-radius: 12px;
        overflow: hidden;
    }

    .btn-outline-secondary {
        border-radius: 24px;
        padding: 8px 20px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejo de pasos
        const steps = document.querySelectorAll('.payment-step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        // Mostrar solo el primer paso inicialmente
        steps[0].classList.remove('d-none');
        // Manejar botones "Siguiente"
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.payment-step');
                const nextStepId = currentStep.id.replace('step', '') * 1 + 1;
                if (nextStepId <= 3) {
                    currentStep.classList.add('d-none');
                    document.getElementById(`step${nextStepId}`).classList.remove('d-none');
                    // Actualizar el stepper
                    updateStepper(nextStepId);
                    // Si vamos al paso 2, actualizar la información mostrada
                    if (nextStepId === 2) {
                        const amount = document.getElementById('amount').value;
                        const email = document.getElementById('email').value;
                        const concept = document.getElementById('concept').value;
                        document.getElementById('display-amount').textContent = `$${parseFloat(amount).toFixed(2)}`;
                        document.getElementById('display-email').textContent = email || 'test@example.com';
                        // Guardar datos en los campos ocultos
                        document.getElementById('form-amount').value = amount;
                        document.getElementById('form-email').value = email;
                        document.getElementById('form-concept').value = concept;
                    }
                }
            });
        });
        // Manejar botones "Atrás"
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.payment-step');
                const prevStepId = currentStep.id.replace('step', '') * 1 - 1;
                if (prevStepId >= 1) {
                    currentStep.classList.add('d-none');
                    document.getElementById(`step${prevStepId}`).classList.remove('d-none');
                    updateStepper(prevStepId);
                }
            });
        });
        // Actualizar el stepper visual
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
        // Mostrar nombre de archivo seleccionado
        document.getElementById('screenshot').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
            document.getElementById('file-name').textContent = fileName;
        });
        // Manejar envío del formulario
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
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Comprobante enviado!',
                        text: 'Tu pago está siendo verificado',
                        confirmButtonColor: '#003087'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al enviar el comprobante',
                        confirmButtonColor: '#003087'
                    });
                }
            })
            .catch(error => {
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

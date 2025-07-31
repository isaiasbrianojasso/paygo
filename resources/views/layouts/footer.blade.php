@php
$uuid = Str::uuid();

@endphp
@if(session('success'))
<script>
    Swal.fire(
        '¡Éxito!',
        '{{ session('success') }}',
        'success'
    );
</script>
@endif

@if(session('payment_check'))
<script>
    Swal.fire({
        title: '¡Éxito!',
        html: `{!! nl2br(e(session('payment_check'))) !!}`,
        icon: 'success'
    });
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        title: 'Error',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
</script>
@endif

@if(session('fail'))
<script>
    Swal.fire(
        '¡Fallo!',
        '{{ session('fallo') }}',
        'error'
    );
</script>
@endif
<!-- BEGIN scroll-top-btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i
        class="fa fa-angle-up"></i></a>
<!-- END scroll-top-btn -->
<div class="card-footer text-center text-muted small">
    This service is powered by <strong>paygo.blog</strong> — All rights reserved © {{ date('Y') }} {{ $uuid }}
</div>
</div>
<!-- END #app -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ================== BEGIN core-js ================== -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>
<!-- ================== END core-js ================== -->

<!-- ================== BEGIN page-js ================== -->
<script src="/assets/js/demo/login-v2.demo.js"></script>
<!-- ================== END page-js ================== -->

<script>
    function generarWhatsappModal() {
            numero = $('[name="Numero_telefono"]').val()
            numero = $('#numerosmsW').val(numero)
            $('#whatsappModal').modal('toggle')
        }

        function generarWhatsapp() {
            numero = $('#numerosmsW').val()
            _token = $('#csrf').val();
            idioma = $('#idiomaWhatsapp').val()
            chat_id = $('[name="chat_id"]').val()
            number = numero
            Swal.fire({
                title: "Generar registro",
                text: "Generar registro whatsapp consume 1 credito!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Generar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/agregarWhatsapp', {
                        _token,
                        number,
                        idioma: idioma,
                        chat_id
                    }, function(resp) {
                        if (resp.ok) {
                            $('[name="mensaje_texto"]').val(resp.mensaje)
                            $('#whatsappModal').modal('toggle')
                        } else {
                            Swal.fire({
                                icon: 'error',
                                html: resp.mensaje
                            });
                        }
                    })
                }
            });
        }
</script>
</body>

</html>

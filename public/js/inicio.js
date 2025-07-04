$(document).ready(function() {
    _token = $('[name="_token"]').val();
})

function isJson(item) {
    item = typeof item !== "string" ?
        JSON.stringify(item) :
        item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}

function detailMessage(params) {

    if (isJson(params)) {
        data = params
    } else {
        data = JSON.parse(params)
    }

    $('#numeroDetail').html(data.number)
    $('#apiDetail').html(data.api_id)
    $('#msjDetail').html(data.msj)
    $('#namesenderDetail').html(data.sender_name)

    if (data.status == '1') {
        $('#statusDetail').html('<span class="badge border border-success text-success px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i> Enviado</span>')
    } else {
        $('#statusDetail').html('<span class="badge border border-danger text-danger px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i> Failed</span>')
    }
    $('#detailSMS').modal('toggle')
}


function abrirEnviarSms() {

    $('#enviarSms').modal('toggle')
}

function handle(e) {
    if (e.keyCode === 13) {
        e.preventDefault(); // Ensure it is only this code that runs

        enviarSms()
    }
}

function contarTexto() {
    mensaje = $('[name="mensaje_texto"]').val()

    cmsj = mensaje.length

    if (cmsj <= 158) {
        $('#mostrarContar').html('<span class="success">' + cmsj + '/ 158</span>')

    } else {
        $('#mostrarContar').html('<span class="dager">No Debes Mandar Un Texto Con Tantos Caracteres</span>')
    }


}


function enviarSms() {
    number = $('[name="Numero_telefono"]').val()
    msj = $('[name="mensaje_texto"]').val()
    sender = $('[name="senderSms"]').val()

    kjnumber = false
    kjmsj = false
    kjsender = false


    if (sender != '') {
        $('#errorSender').attr('hidden', true)
        $('#errorSender').html('')
        kjsender = true
    } else {
        kjsender = false
        $('#errorSender').removeAttr('hidden')
        $('#errorSender').html('Selecciona Un Sender Porfavor..')
    }

    if (number != '' && number.length > 8) {
        $('#errorNumber').attr('hidden', true)
        $('#errorNumber').html('')
        kjnumber = true
    } else {
        kjnumber = false
        $('#errorNumber').removeAttr('hidden')
        $('#errorNumber').html('Ingresa Un Numero Valido Porfavor..')
    }

    if (msj != '' && msj.length > 2) {
        $('#errorMsj').attr('hidden', true)
        $('#errorMsj').html('')
        kjmsj = true
    } else {
        kjmsj = false
        $('#errorMsj').removeAttr('hidden')
        $('#errorMsj').html('Ingresa Un Mensaje Porfavor..')
    }


    if (kjnumber == true && kjmsj == true && kjsender == true) {
        Swal.fire({
            title: 'Espere Porfavor!',
            html: 'Emviando Su Mensaje...',
        });
        Swal.showLoading();

        $.post(
            '/enviandoSms', {
                _token,
                msj,
                number,
                sender
            },
            function(resp) {
                if (resp['ok']) {
                    Swal.fire({
                        title: resp['header'],
                        text: resp['msj'],
                        icon: resp['icon'],
                        didClose: () => {
                            document.location.href = '/home'
                        }

                    })

                } else {
                    Swal.fire(
                        resp['header'],
                        resp['msj'],
                        resp['icon']
                    )
                }
            }
        )

    }


}



function buscar_Apple_Remove() {
    buscar = $('[name="buscarSms"]').val()
    Swal.fire({
        title: 'Espere Porfavor!',
        html: 'Buscando Coincidencias...',
    });

    Swal.showLoading()

    $.post(
        '/buscar_Apple_Remove', {
            _token,
            buscar
        },
        function(resp) {

            tabla = ''
            if (resp.length >= 1) {
                resp.forEach(element => {

                    if (element.status == '1') {
                        jshjd = '<span  class="badge border border-success text-success px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i> Enviado</span>';

                        btnlock = 'btn-warning'
                    } else {
                        jshjd = '<span class="badge border border-danger text-danger px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i> Fallido</span> ';
                        btnlock = 'btn-success'
                    }



                    msjs = JSON.stringify(element)
                    txtShow = element.msj;



                    if (element.status == "1") {

                        shstat = '<span class="badge border border-success text-success px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i> Enviado</span>'
                    } else {
                        shstat = '<span class = "badge border border-danger text-danger px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center" > <i class = "fa fa-circle fs-9px fa-fw me-5px" > </i> Failed</span>';
                    }


                    tabla += '<tr onclick=\'detailMessage(' + msjs + ')\'> <td><a href="javascript:;"  class="fw-bold">#' + element.id + '</a></td><td>Apple ID: ' + element.apple_id + ' <br> Password : ' + element.password + ' <br> ' + element.response + ' </td>< /tr>'

                });
            } else {
                tabla = 'No Se Econtraron Datos'
            }


            $('#filtradosms').html(tabla)
            $('#filtradoCount').html(resp.length)
            Swal.close()


        }
    )






}
function buscarMensaje() {
    buscar = $('[name="buscarSms"]').val()
    Swal.fire({
        title: 'Espere Porfavor!',
        html: 'Buscando Coincidencias...',
    });

    Swal.showLoading()

    $.post(
        '/buscarSms', {
            _token,
            buscar
        },
        function(resp) {

            tabla = ''
            if (resp.length >= 1) {
                resp.forEach(element => {

                    if (element.status == '1') {
                        jshjd = '<span  class="badge border border-success text-success px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i> Enviado</span>';

                        btnlock = 'btn-warning'
                    } else {
                        jshjd = '<span class="badge border border-danger text-danger px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i> Fallido</span> ';
                        btnlock = 'btn-success'
                    }



                    msjs = JSON.stringify(element)

                    txtShow = element.msj;
                    if (txtShow.length >= 25) {
                        txtShow = txtShow.substring(0, 25);
                    }


                    if (element.status == "1") {

                        shstat = '<span class="badge border border-success text-success px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center"><i class="fa fa-circle fs-9px fa-fw me-5px"></i> Enviado</span>'
                    } else {
                        shstat = '<span class = "badge border border-danger text-danger px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center" > <i class = "fa fa-circle fs-9px fa-fw me-5px" > </i> Failed</span>';
                    }


                    tabla += '<tr onclick=\'detailMessage(' + msjs + ')\'> <td><a href="javascript:;"  class="fw-bold">#' + element.id + '</a></td><td>API ID: ' + element.api_id + ' <br> Sender ID: ' + element.sender_id + ' <br> ' + element.sender_name + ' </td> <td>' + txtShow + '...</td> <td>Numero: ' + element.number + ' <br> Costo: $' + element.costo + '</td> <td> ' + shstat + '</td> <td>' + element.created_at + '</td> < /tr>'

                });
            } else {
                tabla = 'No Se Econtraron Datos'
            }


            $('#filtradosms').html(tabla)
            $('#filtradoCount').html(resp.length)
            Swal.close()


        }
    )






}
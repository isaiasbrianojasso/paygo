$(document).ready(function() {
    _token = $('[name="_token"]').val();
    api_key = $('[name="api_key"]').val();
    api_token = $('[name="api_token"]').val();
    URLdomain = window.location.host;
})


function cambiarUrlApi(params) {

    valorApi = $('[name="senderApi"]').val()

    data = params.find(element => element.sender_id == valorApi)
    ponerEnapi = '$url ="http://' + URLdomain + '/apiV2?token=' + api_token + '&sender=' + data.sender_id + '&number=yournumber&msj=your+message" <br> $curl = curl_init($url);<br> curl_setopt($curl, CURLOPT_URL, $url);<br> curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);<br> <br> //for debug only!<br> curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);<br> curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);<br> <br> $resp = curl_exec($curl);<br> curl_close($curl);<br> if($resp["ok"] == true){<br> //Mensaje Enviado<br> }else{<br> //error mensaje no enviado<br> }<br>'

    $('.usoAPI').html(ponerEnapi)

}



function regenerarCredenciales() {
    Swal.fire({
        title: 'Seguro?',
        text: "Tu API key sera renovada",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Generar!'
    }).then((result) => {
        if (result.isConfirmed) {

            Swal.fire({
                title: 'Espere Porfavor !',
                html: 'Generando Nuevas Credenciales',
                allowOutsideClick: false,

            });

            Swal.showLoading()

            $.post(
                '/regenerarCredenciales', {
                    _token
                },
                function(resp) {
                    $('[name="api_key"]').val(resp.api_key);
                    $('[name="api_token"]').val(resp.api_token);

                    Swal.fire({
                        title: 'Exito',
                        text: 'Tus Credenciales Han Sido Actualizadas...',
                        icon: 'success',
                        didClose: () => {
                            document.location.href = '/api_config'
                        }

                    })
                }
            )




        }
    })
}




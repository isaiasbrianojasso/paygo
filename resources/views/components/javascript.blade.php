<script>
    $(document).ready(function() {
    _token = $('[name="_token"]').val();

})

      function ComprarMembresia(tw){

          $("#mostarComprar").modal('toggle');


      }

      function solicitarMembresia(){

          costo = $('[name="costo"]').val();

          Swal.fire({
  title: 'Estas Seguro?',
  text: "Los creditos se descontaran directamente de tu usuario",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si,comprar!'
}).then((result) => {
  if (result.isConfirmed) {

      $.post('/comprarCheck',{_token,costo},function(resp){
          console.log(resp)

          if(resp.ok){
              Swal.fire(
      'Exito!',
      resp.msj,
      'success'
    )
          }else{
              Swal.fire(
      'Error!',
      resp.msj,
      'error'
    )
          }



      })

  }
})

      }
</script>

<script>
    $(document).ready(function() {
    _token = $('[name="_token"]').val();

})

      function ComprarMembresia(tw){

          $("#mostarComprarAutoremove").modal('toggle');


      }

      function resetIpUso(){
          $.post('/resetipAutoremove',{_token},function(resp){


          if(resp.ok){
              Swal.fire(
      'Exito!',
      resp.msj,
      'success'
    )
          }else{
              Swal.fire(
      'Error!',
      resp.msj,
      'error'
    )
          }



      })
      }

      function solicitarMembresia(){

          costo = $('[name="costo"]').val();

          Swal.fire({
  title: 'Estas Seguro?',
  text: "Los creditos se descontaran directamente de tu usuario",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si,comprar!'
}).then((result) => {
  if (result.isConfirmed) {

      $.post('/comprarAutoremove',{_token,costo},function(resp){
          console.log(resp)

          if(resp.ok){
              Swal.fire(
      'Exito!',
      resp.msj,
      'success'
    )
          }else{
              Swal.fire(
      'Error!',
      resp.msj,
      'error'
    )
          }



      })

  }
})

      }
</script>
<script>
    $(document).ready(function() {
        _token = $('[name="_token"]').val();

    })

    function ComprarMembresia(tw) {

        $("#mostarComprarAutoremove").modal('toggle');


    }



    function solicitarMembresia() {

        costo = $('[name="costo"]').val();

        Swal.fire({
            title: 'Estas Seguro?',
            text: "Los creditos se descontaran directamente de tu usuario",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si,comprar!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.post('/comprarAutoremove', {
                    _token,
                    costo
                }, function(resp) {
                    console.log(resp)

                    if (resp.ok) {
                        Swal.fire(
                            'Exito!',
                            resp.msj,
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Error!',
                            resp.msj,
                            'error'
                        )
                    }



                })

            }
        })

    }
</script>

<script>
    function detailNumber(tw){

        $("#mostarNumeros").modal('toggle');

        $.post(
            '/api/mostrarnumeros',{
                id:tw
            },function(resp){
                $('.one').removeAttr('hidden');
                li = ''
                resp.forEach(element => {
                    li += '<li>' +element.numero+'</li></br>'
                });

               $("#mostrarNumbers").html(li)

            }
            )

    }
</script>
<script>
    function detailNumber(tw){

                $("#mostarNumeros").modal('toggle');

                $.post(
                    '/api/mostrarnumeros',{
                        id:tw
                    },function(resp){
                        $('.one').removeAttr('hidden');
                        li = ''
                        resp.forEach(element => {
                            li += '<li>' +element.numero+'</li></br>'
                        });

                       $("#mostrarNumbers").html(li)

                    }
                    )

            }
</script>

<script>
    function salir() {
        Swal.fire({
            tittle: 'Quieres Salir?',
            imageUrl: 'img/logothunder.png',
            imageWidth: 200,
            imageHeight: 200,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#logout').submit()
            }
        })
    }
</script>



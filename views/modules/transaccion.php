<?php
    
    $idTransacc = $_SESSION["idTransaccion"]; 

    $respuesta = ControladorPagos::ctrVerPreTransaccion($idTransacc);

    if ($respuesta) {
        
        $amount = $respuesta["impTotal"];
        $detallePago = "Detalle de pago";

        $token = generateToken();
        $sesion = generateSesion($amount, $token);
        $purchaseNumber = generatePurchaseNumber();

        $updPedidoEnTransaccion = ControladorPagos::ctrActualizarTransaccion($idTransacc, $purchaseNumber);

        if ($updPedidoEnTransaccion == "error") {
          echo "
                <script>
                swal({
                  title: '¡Error!',
                  text: 'No se genero el número de pedido para la transacción.',
                  type: 'error',
                  showConfirmButton: true,
                  confirmButtonText: 'Cerrar',
                    }).then(function(result){
                      if (result.value) {
                        
                          window.location = 'index.php?ruta=clientes&idCliente='+idCliente;
                      }
              
                })
                </script>
          ";
        }

    }else{
        echo '<script>window.location="pagos"</script>';
    }

    

?>

<div class="content content-wrapper">
  <section class="content-header">
    <h1 class="text-uppercase">
      <?php
      echo $_SESSION["nombres"];
      echo '<small> Colegiatura: ' . $_SESSION["cal"] . '</small>';
      echo '<small>                   Estado: </small> <strong>' . $_SESSION["habilitado"] . '</strong>';
      ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="papeleta"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tablero</li>
    </ol>
  </section>

  <section>

    <div class="row">
        <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="text-uppercase">información de pago</h3>
            </div>  
                  
                <div class="box-body">
                  <b style="padding-left:20px;">Importe a pagar: </b> S/. <?php echo $amount; ?> <br>
                  <b style="padding-left:20px;">Número de pedido: </b> <?php echo $purchaseNumber; ?> <br>
                  <b style="padding-left:20px;">Concepto: </b> <?php echo $detallePago; ?> <br>
                  <b style="padding-left:20px;">Fecha: </b> <?php echo date("d/m/Y"); ?> <br> 
                  
                  <form id="frmVisaNet" action="http://localhost/pagovisa/index.php?ruta=finalizar&amount=<?php echo $amount;?>&purchaseNumber=<?php echo $purchaseNumber?>">   
                    <script src="<?php echo VISA_URL_JS?>"
                        data-sessiontoken="<?php echo $sesion;?>"
                        data-channel="web"
                        data-merchantid="<?php echo VISA_MERCHANT_ID?>"
                        data-merchantlogo="https://blog.solutekcolombia.com/wp-content/uploads/2019/02/mastercard-new-logo-content-2019.jpg"
                        data-purchasenumber="<?php echo $purchaseNumber;?>"
                        data-amount="<?php echo $amount; ?>"
                        data-expirationminutes="5"
                        data-timeouturl="http://localhost/pagovisa/"
                    ></script> 
                  </form>              
                </div>
                <div class="box-footer">
                  <input type="checkbox" name="ckbTerms" id="ckbTerms" onclick="visaNetEc3()"> <label for="ckbTerms">Acepto los <a href="#" target="_blank">Términos y condiciones</a></label>
                </div>
              
        </div>
        </div>
    </div>
  </section>
</div>
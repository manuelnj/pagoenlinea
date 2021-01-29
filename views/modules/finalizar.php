<?php
    // include 'config/functions.php';
    $transactionToken = $_POST["transactionToken"];
    $email = $_POST["customerEmail"];
    $amount = $_GET["amount"];
    $purchaseNumber = $_GET["purchaseNumber"];

    if (isset($_POST['url'])) {
        header("Location: {$_POST['url']}");
        die();
    }

    $token = generateToken();

    $data = generateAuthorization($amount, $purchaseNumber, $transactionToken, $token);

    $idTransaccion = $_SESSION["idTransaccion"]; 

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
              <?php
                if (isset($data->dataMap)) {
                    if ($data->dataMap->ACTION_CODE == "000") {
                        $c = preg_split('//', $data->dataMap->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $data->dataMap->ACTION_DESCRIPTION;?>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <b>Número de pedido: </b> <?php echo $purchaseNumber; ?>
                                </div>
                                <div class="col-md-12">
                                    <b>Fecha y hora del pedido: </b> <?php echo $c[4].$c[5]."/".$c[2].$c[3]."/".$c[0].$c[1]." ".$c[6].$c[7].":".$c[8].$c[9].":".$c[10].$c[11]; ?>
                                </div>
                                <div class="col-md-12">
                                    <b>Tarjeta: </b> <?php echo $data->dataMap->CARD." (".$data->dataMap->BRAND.")"; ?>
                                </div>
                                <div class="col-md-12">
                                    <b>Importe pagado: </b> <?php echo $data->order->amount. " ".$data->order->currency; ?>
                                </div>
                            </div>
                        <?php

                          // actualizar datos de la transacción.
                          if ($data->dataMap->STATUS == "Authorized") {
                            $vIdRespuesta = 1;
                            $visaEstado = 'AUTORIZADO';
                          }else{
                            $vIdRespuesta = 2;
                            $visaEstado = 'DENEGADO';
                          }


                          $arrayVisa = array(
                                          "visaETicket" => $purchaseNumber,
                                          "estadosTransaccion" => "F",
                                          "visaRespuesta" => $vIdRespuesta,
                                          "visaEstado" => $visaEstado,
                                          "visaCodAccion" => $data->dataMap->ACTION_CODE,
                                          "visaDscCodAccion" => $data->dataMap->ACTION_DESCRIPTION,
                                          "visaPAN" => $data->dataMap->CARD,
                                          "visaNomEmisor" => $data->dataMap->BRAND,
                                          "visaECI" => $data->dataMap->ECI,
                                          "visaDescECI" => $data->dataMap->ECI_DESCRIPTION,
                                          "visaCodAutor" => $data->dataMap->ADQUIRENTE,
                                          "visaIdUnico" => $data->dataMap->ID_UNICO,
                                          "visaImpAutorizado" => $data->order->amount,
                                          "visaFechaHoraTx" => $c[4].$c[5]."/".$c[2].$c[3]."/".$c[0].$c[1]." ".$c[6].$c[7].":".$c[8].$c[9].":".$c[10].$c[11],
                                          "visaDatoComercio" => $data->dataMap->MERCHANT
                                        );
                          
                          $visaRespuesta = ControladorPagos::ctrActualizaRespuestaVisa($idTransaccion, $arrayVisa);
                          
                    }
                } else {
                    $c = preg_split('//', $data->data->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $data->data->ACTION_DESCRIPTION;?>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <b>Número de pedido: </b> <?php echo $purchaseNumber; ?>
                            </div>
                            <div class="col-md-12">
                                <b>Fecha y hora del pedido: </b> <?php echo $c[4].$c[5]."/".$c[2].$c[3]."/".$c[0].$c[1]." ".$c[6].$c[7].":".$c[8].$c[9].":".$c[10].$c[11]; ?>
                            </div>
                            <div class="col-md-12">
                                <b>Tarjeta: </b> <?php echo $data->data->CARD." (".$data->data->BRAND.")"; ?>
                            </div>
                        </div>
                    <?php

                      // actualizar datos de la transacción.
                      if ($data->data->STATUS == "Authorized") {
                        $vIdRespuesta = 1;
                        $visaEstado = 'AUTORIZADO';
                      }else{
                        $vIdRespuesta = 2;
                        $visaEstado = 'DENEGADO';
                      }


                      $arrayVisa = array(
                                      "visaETicket" => $purchaseNumber,
                                      "estadosTransaccion" => "C",
                                      "visaRespuesta" => $vIdRespuesta,
                                      "visaEstado" => $visaEstado,
                                      "visaCodAccion" => $data->data->ACTION_CODE,
                                      "visaDscCodAccion" => $data->data->ACTION_DESCRIPTION,
                                      "visaPAN" => $data->data->CARD,
                                      "visaNomEmisor" => $data->data->BRAND,
                                      "visaECI" => $data->data->ECI,
                                      "visaDescECI" => $data->data->ECI_DESCRIPTION,
                                      "visaCodAutor" => $data->data->ADQUIRENTE,
                                      "visaIdUnico" => $data->data->ID_UNICO,
                                      "visaImpAutorizado" => 0,
                                      "visaFechaHoraTx" => $c[4].$c[5]."/".$c[2].$c[3]."/".$c[0].$c[1]." ".$c[6].$c[7].":".$c[8].$c[9].":".$c[10].$c[11],
                                      "visaDatoComercio" => $data->data->MERCHANT
                                    );
                      
                      $visaRespuesta = ControladorPagos::ctrActualizaRespuestaVisa($idTransaccion, $arrayVisa);

                }
              ?>
            </div>
            <div class="box-footer">
              <a href="inicio" class="btn btn-primary btn-block">
                <i class="fa fa-reply"></i>
                Regresar

              </a>
            </div>
              
        </div>
        </div>
    </div>
  </section>
</div>


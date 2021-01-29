<div class="content-wrapper">
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

  <section class="content">
    <?php

      $host = $_SERVER["HTTP_HOST"];
      $url  = $_SERVER["REQUEST_URI"];

      $urlMaster = "http://".$host.$url;

      $components = parse_url($urlMaster, PHP_URL_QUERY);
      
      parse_str($components, $results);

      $codProd = $results["id"];

      $_SESSION["idProducto"] = $codProd;

      // obtener el tipo de cambio
      $rptaTC = ControladorPagos::ctrTipoCambio();
      $tc = $rptaTC["tc"];
      //fin

      // obtener el precio del producto.
      if ($codProd == 1) {
        $retPrecio = ControladorPagos::ctrConsultarPrecio($codProd);
      }elseif ($codProd == 3) {
        $retPrecio = ControladorPagos::ctrConsultarPrecio($codProd);
      }elseif ($codProd == 4) {
        $retPrecio = ControladorPagos::ctrConsultarPrecio($codProd);
      }

      $persona = $_SESSION["persona"];

      $valCuota = $retPrecio["precio"];
      $desProducto = $retPrecio["descripcionproducto"];

      

    ?>

        <div class="row">
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <!-- <h3>Cuotas Ordinarias</h3> -->
                <?php 
                  
                  $rpta = ControladorPagos::ctrUltimoPeriodoPago($_SESSION["cal"], $codProd);

                  $periodoPago = $rpta["periodo"];
                
                ?>
                <h5 class="text-uppercase">Último Periodo de Pago: <strong><?php echo $periodoPago; ?></strong></h5>
              </div>

              <form action="" role="form" method="post">
                <div class="box-body">
                  
                  <?php

                    if($_SESSION["idProducto"] == 4){

                      $retTotCasilla = ControladorPagos::ctrTotCasilla($persona);

                      $totCasilla = $retTotCasilla["Cantidad"];

                      $retLstCasilla = ControladorPagos::ctrListarCasilla($persona, $totCasilla);

                      echo  '
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="">Pago por :</label>
                                    <input type="text" class="form-control input-sm text-uppercase text-bold" id="" value="'.$desProducto.'" readonly>
                                    <input type="hidden" id="valorProducto" name="valorProducto" value='.$_SESSION["idProducto"].'>
                                    <input type="hidden" id="valorPersona" name="valorPersona" value='.$persona.'>
                                    <input type="hidden" id="valorCuota" name="valorCuota">
                                    <input type="hidden" id="valorTC" name="valorTC" value='.$tc.'>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="">Seleccionar casilla :</label>
                                    <select class="form-control input-sm text-uppercase" name="valorCasilla" id="valorCasilla">
                                      <option value="0">:: seleccionar casilla ::</option>';
                                      if ($totCasilla == 1) {
                                        echo '<option value='.$retLstCasilla["NumeroCasilla"].'>'.$retLstCasilla["NumeroCasilla"].'</option>';  
                                      }else{
                                        foreach ($retLstCasilla as $key => $value) {
                                          echo '<option value='.$value["NumeroCasilla"].'>'.$value["NumeroCasilla"].'</option>';                                                   
                                        }
                                      }
                                      
                      echo  '       </select>
                                  </div>
                                </div>
                              </div>
                            ';
                    }else{
                      echo '<div class="form-group">
                              <label for="">Pago por :</label>
                              <input type="text" class="form-control input-sm text-uppercase text-bold" id="" value="'.$desProducto.'" readonly>
                              <input type="hidden" id="valorProducto" name="valorProducto" value='.$_SESSION["idProducto"].'>
                              <input type="hidden" id="valorPersona" name="valorPersona" value='.$persona.'>
                              <input type="hidden" id="valorCuota" name="valorCuota" value='.$valCuota.'>
                              <input type="hidden" id="valorTC" name="valorTC" value='.$tc.'>
                            </div>';
                    }
                  ?>
                  <input type="hidden" id="ultPeriodoPago" value="<?php echo $periodoPago; ?>">
                  <div class="form-group">
                    <label for="">Cuotas :</label>
                    <select class="form-control input-sm text-uppercase" name="selCuota" id="selCuota">
                      <option value="0">:: Seleccionar ::</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>                     
                    </select>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">Importe (S/.):</label>
                        <input type="text" class="form-control input-sm text-bold text-blue text-right" name="valorImporte" id="valorImporte" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">Pago - canal Online</label>
                        <input type="text" class="form-control input-sm text-bold text-blue text-right" name="valorImpuesto" id="valorImpuesto" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="">Total a pagar (S/.)</label>
                        <input type="text" class="form-control input-sm text-bold text-blue text-right" name="valorTotalImporte" id="valorTotalImporte" readonly>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="">Elegir el tipo de comprobante de pago</label>
                    <select class="form-control input-sm text-uppercase" name="selDocumento" id="selDocumento">
                      <option value="0">:: Seleccionar documento ::</option>
                      <option value="BV">Boleta de Venta</option>
                      <option value="FC">Factura</option>
                    </select>
                  </div>

                  <div class="form-group divruc">
                    <label for="">RUC</label>
                    <input type="text" class="form-control input-sm text-uppercase" name="valorRUC" id="valorRUC" maxlength="11">
                  </div>

                  <div class="form-group divrsoc">
                    <label for="">Razón Social</label>
                    <input type="text" class="form-control input-sm text-uppercase" name="valorNombre" id="valorNombre" maxlength="66">
                  </div>

                  <div class="form-group divDomf">
                    <label for="">Domicilio Fiscal</label>
                    <input type="text" class="form-control input-sm text-uppercase" name="valorDomicilio" id="valorDomicilio" maxlength="100">
                  </div>

                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-block text-uppercase btnSiguiente">
                    <i class="fa fa-check-square-o"></i> Siguiente
                  </button>
                </div>
                <?php
                  $transaccion = new ControladorPagos();
                  $transaccion -> ctrPreTransaccion();
                ?>
              </form>
            </div>
          </div>
        </div>



  </section>
</div>
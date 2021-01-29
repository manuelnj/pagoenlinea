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
    <div class="row">
      <div class="col-md-6">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title text-uppercase"><strong>Últimos Pagos</strong></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th class="text-uppercase">Transacción</th>
                    <th class="text-uppercase">Producto</th>
                    <th class="text-uppercase">Fecha Pago</th>
                    <th class="text-uppercase">Estado</th>
                    <th class="text-uppercase">Monto</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $nroCal = $_SESSION["cal"];
                  $lstUltPago = ControladorPagos::ctrUltimosPagos($nroCal);

                  foreach ($lstUltPago as $key => $value) {

                    if ($value["visaEstado"] == "AUTORIZADO") {
                      $color = "label-success";
                      $rEstado = "AUTORIZADO";
                    } else {
                      $color = "label-danger";
                      $rEstado = "DENEGADO";
                    }

                    switch ($value["idProducto"]) {
                      case 1:
                        $detalle = "PAPELETA DE HABILIDAD";
                        break;
                      case 3:
                        $detalle = "CUOTAS ORDINARIAS";
                        break;
                      case 4:
                        $detalle = "CASILLAS - " . $value["adicional5"];
                        break;
                      default:
                        # code...
                        break;
                    }

                    $f = date("Y-m-d H:i:s", strtotime($value["fechaHoraCreacion"]));

                    echo '<tr>
                              <td><a href="#">' . $value["idTransaccion"] . '</a></td>
                              <td>' . $detalle . '</td>
                              <td>' . $f . '</td>
                              <td><span class="label ' . $color . '">' . $rEstado . '</span></td>
                              <td class="text-rigth">' . $value["impTotal"] . '</td>
                            </tr>';
                  }

                  ?>

                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">

          </div>
          <!-- /.box-footer -->
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Pagos realizados</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <?php

            $ph = ControladorPagos::ctrSumaUltPagos($nroCal, "1");
            $co = ControladorPagos::ctrSumaUltPagos($nroCal, "3");
            $ca = ControladorPagos::ctrSumaUltPagos($nroCal, "4");

            $v1 = (float)$co["suma"];
            $v2 = (float)$ca["suma"];
            $v3 = (float)$ph["suma"];

            echo '<script>
                  var pieData = [{
                      value: '.$v1.',
                      color: "#F7464A",
                      highlight: "#FF5A5E",
                      label: "Cuotas Ordinarias"
                    },
                    {
                      value: '.$v2.',
                      color: "#46BFBD",
                      highlight: "#5AD3D1",
                      label: "Casillas"
                    },
                    {
                      value: '.$v3.',
                      color: "#FDB45C",
                      highlight: "#FFC870",
                      label: "Papeleta de Habilidad"
                    }          
                  ];
                </script>';
          ?>
          <div class="box-body">
            <div class="row">
              <div class="col-md-8">
                <div id="canvas-holder">
                  <canvas id="chart-area" width="160" height="257" style="width: 257px; height: 237px;" />
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <ul class="chart-legend clearfix">
                  <li><i class="fa fa-circle-o text-red"></i> Coutas Ordinarias</li>
                  <li><i class="fa fa-circle-o text-green"></i> Casillas</li>
                  <li><i class="fa fa-circle-o text-yellow"></i> Papeleta de Habilidad</li>
                </ul>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer no-padding">
          </div>
          <!-- /.footer -->
        </div>
      </div>
    </div>
  </section>
</div>
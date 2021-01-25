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

    // actualizar la transaccion.
    if (isset($data)) {
    //    echo $data->data->merchantId;
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
                <?php
                    var_dump($data);
                ?>
            </div>
            <div class="box-footer">
            </div>
              
        </div>
        </div>
    </div>
  </section>
</div>


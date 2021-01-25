<div class="content-wrapper">
  <section class="content-header">
    <h1 class="text-uppercase">
      <?php
        echo $_SESSION["nombres"];
        echo '<small> Colegiatura: '.$_SESSION["cal"].'</small>';
        echo '<small>                   Estado: </small> <strong>'.$_SESSION["habilitado"] .'</strong>';
      ?>
      
    </h1>
    <ol class="breadcrumb">
      <li><a href="papeleta"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tablero</li>
    </ol>
  </section>
  <section class="content">
  </section>
</div>
<div id="back"></div>
<div class="login-box">

  <div class="login-logo">

    <!-- <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive" style="padding:30px 100px 0px 100px"> -->

  </div>

  <div class="login-box-body">

    <p class="login-box-msg text-uppercase text-bold">Acceso - Pago en Línea</p>

    <form method="post">

      <div class="form-group has-feedback">
        
        <label for="">Usuario (N° de Colegiatura | N° de Casilla)</label>
        
        <input type="number" class="form-control" placeholder="colegiatura : 99999" name="ingUsuario" maxlength="6" required>

        <span class="glyphicon glyphicon-user form-control-feedback"></span>

      </div>

      <div class="form-group has-feedback">

        <label for="">Contraseña</label>

        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>

        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

      </div>

      <div class="row">

        <div class="col-xs-4">

          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>

        </div>

      </div>

      <?php

      $login = new ControladorUsuarios();

      $login->ctrIngresoUsuario();

      ?>
    </form>
  </div>
</div>
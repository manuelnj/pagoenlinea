<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Colegio de Abogados de Lima | Pagos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- <link rel="icon" href="views/assets/img/plantilla/icono-negro.png"> -->
  <!--=====================================
  PLUGINS DE CSS
  ======================================-->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="views/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/assets/dist/css/AdminLTE.css">
  <!-- <link rel="stylesheet" href="views/assets/dist/css/papeleta.css"> -->
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="views/assets/dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="views/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="views/assets/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="views/assets/plugins/iCheck/all.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="views/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="views/assets/bower_components/morris.js/morris.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="views/assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->
  <!-- jQuery 3 -->
  <script src="views/assets/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="views/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="views/assets/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="views/assets/dist/js/adminlte.min.js"></script>
  <!-- DataTables -->
  <script src="views/assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="views/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="views/assets/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="views/assets/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <!-- SweetAlert 2 -->
  <script src="views/assets/plugins/sweetalert2/sweetalert2.all.js"></script>
  <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="views/assets/plugins/iCheck/icheck.min.js"></script>
  <!-- InputMask -->
  <script src="views/assets/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="views/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="views/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- jQuery Number -->
  <script src="views/assets/plugins/jqueryNumber/jquerynumber.min.js"></script>
  <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="views/assets/bower_components/moment/min/moment.min.js"></script>
  <script src="views/assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="views/assets/bower_components/raphael/raphael.min.js"></script>
  <script src="views/assets/bower_components/morris.js/morris.min.js"></script>
  <!-- ChartJS http://www.chartjs.org/-->
  <script src="views/assets/bower_components/Chart.js/Chart.js"></script>
  <!-- bootstrap datepicker -->
  <script src="views/assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
  <!-- <script src="views/assets/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.js"></script> -->
  <!-- Impresion -->
  <!-- <script src="views/assets/plugins/printthis.js"></script> -->
</head>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
  
  <?php

    if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

      echo '<div class="wrapper">';

      include "modules/cabezote.php";

      include "modules/menu.php";
      
      if (isset($_GET["ruta"])) {

        if (
          $_GET["ruta"] == "papeleta" ||
          $_GET["ruta"] == "inicio" ||
          $_GET["ruta"] == "pagos" ||
          $_GET["ruta"] == "transaccion" ||
          $_GET["ruta"] == "finalizar" ||
          $_GET["ruta"] == "salir"

        ) {

          include "modules/" . $_GET["ruta"] . ".php";

        } else {

          include "modules/404.php";
        }
      } else {

        // include "modules/papeleta.php";

      }

      include "modules/footer.php";

      echo '</div>';
    } else {

      include "modules/login.php";
    }
  ?>

  <!-- <script src="views/assets/js/plantilla.js"></script> -->
  <script src="views/assets/js/script.js"></script>
  <script src="views/assets/js/pagos.js"></script>
</body>
</html>
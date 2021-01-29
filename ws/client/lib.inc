<?php

// PRUEBAS
//define('URL_WS_TX_CAL','http://localhost/ws/ws_consulta.php?wsdl');
// PRODUCCIÓN
//define('URL_WS_TX_CAL','http://www.calperu.org/ws/ws_consulta.php?wsdl');
define('URL_WS_TX_CAL','http://200.48.20.156/ws/ws_consulta.php?wsdl');


///PROXY
define('PROXY_ON', false);
define('PROXY_HOST','172.16.60.3');
define('PROXY_PORT',3128);
define('PROXY_LOGIN','dominio\usuario');
define('PROXY_PASSWORD','clave');

function noCache() {
  header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}


?>

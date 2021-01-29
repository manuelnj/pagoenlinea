<?php
	session_start(); 
	include('lib.inc');

	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	ini_set('date.timezone', 'America/Lima'); 
	header( 'Content-Type: text/html;charset=utf-8' );
	noCache();
?>
<?php
	
		//Se asigna el código de comercio y Nro. de pedido
		// $accessKey= "c2f94210-8bdf-11e3-baa8-0800200c9a66";
		// $fecha= "2018/04/19";
		// $calId= "54449";
		
		//Se arma el XML de requerimiento
		$xmlIn = "";
		
		//Se asigna la url del servicio
		$servicio= URL_WS_TX_CAL;
		
		//Invocación del web service
		// $conf=array();
		// $conf["cache_wsdl"]= WSDL_CACHE_NONE;
		// //Se habilita el parametro PROXY_ON en el archivo "lib.inc" si se maneja algun proxy para realizar conexiones externas.
		// if(PROXY_ON == true){
		// 	$conf=array('proxy_host'     => PROXY_HOST,
		//                     'proxy_port'     => PROXY_PORT,
		//                     'proxy_login'    => PROXY_LOGIN,
		//                     'proxy_password' => PROXY_PASSWORD);
		// }
		
		// $client = new SoapClient($servicio, $conf);
    
    //parametros de la llamada
		// $parametros=array(); 

		// $parametros["accessKey"]= $accessKey;
		// $parametros["fecha"]= $fecha;
		// $parametros["calId"]= $calId;
		
		// //Aqui captura la cadena de resultado
		// $result = $client->__soapCall('consultaTx', $parametros);
		
		// print_r($result);
		
?>
<html>
<head>
	<title>Prueba Cliente WS</title>
</head>
<body>
	&nbsp;
</body>
</html>


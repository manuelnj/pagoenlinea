<?php
require_once('lib/nusoap.php');

include('connect-db.php');

// $ns="http://200.48.20.157/ws"; 

$ns="http://pagoenlineacal.org.pe/ws/";

$server = new soap_server();
$server->soap_defencoding = 'utf-8';
$server->decode_utf8 = false;
$server->configureWSDL('consultaTx',$ns);
$server->wsdl->schemaTargetNamespace=$ns;

$server->register('consultaTx',
									array(
											  'accessKey' => 'xsd:string',
											  'fecha' => 'xsd:string',
											  'calId' => 'xsd:string'
											  ),
									array('return' => 'xsd:string'),
									$ns,
									$ns,
								  'rpc',
								  'encoded',
								  'Reporte de Transacciones');

function consultaTx($accessKey,
										$fecha,
										$calId ){

	if($accessKey != "c2f94210-8bdf-11e3-baa8-0800200c9a66"){
		$mensaje= array();
		$mensaje["error"]= 400;
		$mensaje["mensaje"]= "Acceso no permitido";
		return $mensaje;
	}

	// echo "kes is:".($accessKey);

	$buscar= "";
	$hoy = getdate();

	if(empty($fecha)){
		// $fecha= $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
		$fecha = date("Y-m-d");
	}
	
	// $buscar= " AND (fechaHoraCreacion BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:59') ";

	$buscar= " AND DATE(fechaHoraCreacion) = '".$fecha."'";

	if(!empty($calId)){
		$buscar= $buscar . " AND idCAL like '%".$calId."%' ";
	}

	// obteniendo el monto de descuento


	$sqlStr= "SELECT T.idTransaccion,
					T.idCliente,
				    P.idProducto,
				    P.descripcionProducto,
				    T.cantidad,
				    T.impTotal,
				    T.fechaHoraCreacion,
				    T.idTransaccion,
						T.idCliente,
						T.idCAL,
						T.estadosTransaccion,
						T.visaETicket,
						T.visaMensaje,
						T.visaRespuesta,
						T.visaEstado,
						T.visaCodAccion,
						T.visaPAN,
						T.visaTH,
						T.visaOriTarjeta,
						T.visaNomEmisor,
						T.visaECI,
						T.visaDescECI,
						T.visaCodAutor,
						T.visaCodRescvv2,
						T.visaIdUnico,
						T.visaImpAutorizado,
						T.visaFechaHoraTx,
						T.visaFechaHoraDeposito,
						T.visaFechaHoraDevolucion,
						T.visaDatoComercio,
						T.adicional1,
						T.adicional2,
						T.adicional3,
						T.adicional4,
						T.adicional5
				FROM tb_transaccion T
				INNER JOIN tb_producto AS P ON T.idProducto=P.idProducto
				AND estadosTransaccion ='F' AND T.visaEstado = 'AUTORIZADO'".$buscar.";";
	//echo $sqlStr;

	$r = Conexion::resultados($sqlStr);

	$transaccion = array();

	$transacciones = "<?xml version=\"1.0\" encoding=\"utf-8\"?><transaccion>";

	foreach ($r as $key => $value) {
		
		$transaccion[] = $value;

		$item="<item>";
		$item.= "<idTransaccion>".$value["idTransaccion"]."</idTransaccion>";
		$item.= "<idCliente>".$value["idCliente"]."</idCliente>";
		$item.= "<idProducto>".$value["idProducto"]."</idProducto>";
		$item.= "<descripcionProducto>".$value["descripcionProducto"]."</descripcionProducto>";
		$item.= "<cantidad>".$value["cantidad"]."</cantidad>";
		$item.= "<impTotal>".$value["impTotal"]."</impTotal>";
		$item.= "<fechaHoraCreacion>".$value["fechaHoraCreacion"]."</fechaHoraCreacion>";
		$item.= "<idCAL>".$value["idCAL"]."</idCAL>";
		$item.= "<estadosTransaccion>".$value["estadosTransaccion"]."</estadosTransaccion>";
		$item.= "<visaETicket>".$value["visaETicket"]."</visaETicket>";
		$item.= "<visaMensaje>".$value["visaMensaje"]."</visaMensaje>";
		$item.= "<visaRespuesta>".$value["visaRespuesta"]."</visaRespuesta>";
		$item.= "<visaEstado>".$value["visaEstado"]."</visaEstado>";
		$item.= "<visaCodAccion>".$value["visaCodAccion"]."</visaCodAccion>";
		$item.= "<visaPAN>".$value["visaPAN"]."</visaPAN>";
		$item.= "<visaTH>".$value["visaTH"]."</visaTH>";
		$item.= "<visaOriTarjeta>".$value["visaOriTarjeta"]."</visaOriTarjeta>";
		$item.= "<visaNomEmisor>".$value["visaNomEmisor"]."</visaNomEmisor>";
		$item.= "<visaECI>".$value["visaECI"]."</visaECI>";
		$item.= "<visaDescECI>".$value["visaDescECI"]."</visaDescECI>";
		$item.= "<visaCodAutor>".$value["visaCodAutor"]."</visaCodAutor>";
		$item.= "<visaCodRescvv2>".$value["visaCodRescvv2"]."</visaCodRescvv2>";
		$item.= "<visaIdUnico>".$value["visaIdUnico"]."</visaIdUnico>";
		$item.= "<visaImpAutorizado>".$value["visaImpAutorizado"]."</visaImpAutorizado>";
		$item.= "<visaFechaHoraTx>".$value["visaFechaHoraTx"]."</visaFechaHoraTx>";
		$item.= "<visaFechaHoraDeposito>".$value["visaFechaHoraDeposito"]."</visaFechaHoraDeposito>";
		$item.= "<visaFechaHoraDevolucion>".$value["visaFechaHoraDevolucion"]."</visaFechaHoraDevolucion>";
		$item.= "<visaDatoComercio>".$value["visaDatoComercio"]."</visaDatoComercio>";
		$item.= "<adicional1>".$value["adicional1"]."</adicional1>";
		$item.= "<adicional2>".$value["adicional2"]."</adicional2>";
		$item.= "<adicional3>".$value["adicional3"]."</adicional3>";
		$item.= "<adicional4>".$value["adicional4"]."</adicional4>";
		$item.= "<adicional5>".$value["adicional5"]."</adicional5>";
	  	$item.="</item>";
	  	$transacciones.=$item;

	}

	$transacciones.= "</transaccion>";


	return $transacciones;
//exit;

	//return $transaccion;
}

if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);

?>

<?php
	include('valida_sesion.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Colegio de Abogados de Lima - Transacciones</title>
	<!-- Inserción de javascript para validaciones -->
	<script type="text/javascript" src="js/validaciones.js"></script>
	<link rel="stylesheet" type="text/css" href="css/atis.css"/>

	<script type="text/javascript" >
		function exportarRegistros() {
			//window.open('about:blank','Popup_Window','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600,left = 100,top = 100');

			var form = document.createElement("form");
	    form.setAttribute("method", "post");
	    form.setAttribute("action", "export.php");
	    //form.setAttribute("target", "Popup_Window");

	    var hiddenField = document.createElement("input");
	    hiddenField.setAttribute("name", "fecha");
	    hiddenField.setAttribute("type", "hidden");
	    hiddenField.setAttribute("value", document.getElementById("fecha").value);
	    form.appendChild(hiddenField);

	    var hiddenField = document.createElement("input");
	    hiddenField.setAttribute("name", "idCAL");
	    hiddenField.setAttribute("type", "hidden");
	    hiddenField.setAttribute("value", document.getElementById("idCAL").value);
	    form.appendChild(hiddenField);

	    document.body.appendChild(form);    // Not entirely sure if this is necessary

	    form.submit();
		}
	</script>
	<script>
	function verDetalle(idTransaccion) {
		window.open('about:blank','Popup_DetalleTx','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600,left = 100,top = 100');

		var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "detalle_transaccion.php");
    form.setAttribute("target", "Popup_DetalleTx");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "idTransaccion");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", idTransaccion);
    form.appendChild(hiddenField);

    document.body.appendChild(form);    // Not entirely sure if this is necessary

    form.submit();
	}
</script>
</head>

<body>

<?php
	$buscar= "";
	$hoy = getdate();

	$fecha = $hoy["year"] . "/" . $hoy["mon"] . "/" . $hoy["mday"];
	$idCAL = "";

	$buscar= " WHERE (fechaHoraCreacion BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:59') ";
	if (isset($_POST["buscar"])){

		if(!empty($_POST["fecha"])){
			$fecha = $_POST["fecha"];
			$buscar= " WHERE (fechaHoraCreacion BETWEEN '".$fecha." 00:00:00' AND '".$fecha." 23:59:59') ";
		}

		if(!empty($_POST["idCAL"])){
			$idCAL = $_POST["idCAL"];
			$buscar= $buscar . " AND idCAL like '%".$idCAL."%' ";
		}
	}

	include('header.php');
	include('connect-db.php');

	$sql= "SELECT T.idTransaccion,
	CONCAT( C.apellidoCliente,  ', ', C.nombreCliente ) AS  'Cliente',
    P.idProducto,
    P.descripcionProducto,
    T.cantidad,
    T.impTotal,
    T.fechaHoraCreacion,
    T.*
FROM cal_pagosweb.tb_transaccion T
INNER JOIN cal_pagosweb.tb_cliente AS C ON T.idCliente=C.idCliente
INNER JOIN cal_pagosweb.tb_producto AS P ON T.idProducto=P.idProducto" . $buscar .";";
	//echo $sql;
	$result = mysql_query($sql) or die(mysql_error());

	?>
	<br/><br/>
	<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<td><b>Listado de Transacciones:</b></td>
		</tr>
		<tr valign="top">
			<td>
				<form method="POST">
					<table border="1" width="50%" cellpadding="2" cellspacing="0">
						<tr>
							<td width="40%"><b>Fecha (yyyy/mm/dd):</b></td>
							<td align="center">
								<input name="fecha" id="fecha" type="text" value="<?php echo $fecha; ?>" size="10" style="text-align:center;"/>
							</td>
							<td rowspan="3" align="center"><input name="exportar" id="exportar" type="button" value="Exportar" onclick="exportarRegistros();" /></td>
						</tr>
						<tr>
							<td><b>CAL Id:</b></td>
							<td align="center">
								<input name="idCAL" id="idCAL" type="text" value="<?php echo $idCAL; ?>" size="10" style="text-align:center;"/>
							</td>
						</tr>
						<tr>
							<td colspan= "2" align="center">
								<input name="buscar" id="buscar" type="submit" value="Buscar" />
							</td>
						</tr>
					</table>
				</form>
				<br/></td>
			</td>
		</tr>
	<tr>
		<td>


	<?php

		// Tabla interna, muestra datos
		echo "<table border='1' cellpadding='5' cellspacing='0' align='center' width='100%'>
					 <tr>
	        	<th width='40px'>ID</th>
	        	<th>Cliente</th>
	        	<th>Producto</th>
	        	<th>Cantidad</th>
	        	<th>Importe</th>
	        	<th>Fecha</th>
	        	<th width='80px'></th>
        	</tr>";

        while($row = mysql_fetch_array( $result )) {
			echo "<tr>";
			echo '<td>' . $row['idTransaccion'] . '</td>';
			echo '<td>' . $row['Cliente'] . '</td>';
			echo '<td>' . $row['descripcionProducto'] . '</td>';
			echo '<td align="center">' . $row['cantidad'] . '</td>';
			echo '<td align="right">' . $row['impTotal'] . '</td>';
			echo '<td align="center">' . $row['fechaHoraCreacion'] . '</td>';
			echo '<td align="center"><a href="#" onclick="verDetalle(' . $row['idTransaccion'] . ')">Detalle</a></td>';
			//echo '<td align="center"><a href="detalle_transaccion.php?id=' . $row['idTransaccion'] . '" onclick="verDetalle(' . $row['idTransaccion'] . ')">Detalle</a></td>';
			echo "</tr>";
        }

		echo "</table>";

	echo "</td> </tr>";
	echo "</table>";

?>

</body>

</html>

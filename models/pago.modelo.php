<?php

require_once "conexion.php"; 

class ModeloPagos{

    static public function mdlUltimoPeriodoPago($cal, $item){

        $url = "http://servicioscal.org.pe/APICasilla/apiCasillas.php?vCal03=".$cal."&vICod=".$item;
        
        $json = file_get_contents($url);

		$datos = json_decode($json, true);

		return $datos;
    }

    static public function mdlConsultarPrecio($valor){
        
        $url = "http://servicioscal.org.pe/APICasilla/apiCasillas.php?vKeyProducto=".$valor;

        $json = file_get_contents($url);

		$datos = json_decode($json, true);

		return $datos;
    }

    static public function mdlTipoCambio(){
        
        $url = "http://servicioscal.org.pe/APICasilla/apiCasillas.php?vTipoCambio=1";

        $json = file_get_contents($url);

		$datos = json_decode($json, true);

		return $datos;
    }

    static public function mdlCantCasilla($data){
        
        $url = "http://servicioscal.org.pe/APICasilla/apiCasillas.php?isPersona=".$data;

        $json = file_get_contents($url);

		$datos = json_decode($json, true);

		return $datos;
    }

    static public function mdlListarCasilla($data, $unidad){

        $url = "http://servicioscal.org.pe/APICasilla/apiCasillas.php?numPersona=".$data."&cantidad=".$unidad;

        $json = file_get_contents($url);

		$datos = json_decode($json, true);

		return $datos;
    }

    static public function mdlPrecioCasilla($persona, $casilla){

        $url = "http://servicioscal.org.pe/APICasilla/apiCasillas.php?isPersona02=".$persona."&isCasilla02=".$casilla;

        $json = file_get_contents($url);

		$datos = json_decode($json, true);

		return $datos;
    }

    static public function mdlPreTransaccion($tabla, $datos){

        $db = Conexion::conectar();

        $stmt = $db->prepare("INSERT INTO tb_transaccion(  idCliente,
                                                                            idCAL,
                                                                            idProducto,
                                                                            cantidad,
                                                                            impTotal,
                                                                            estadosTransaccion,
                                                                            adicional1,
                                                                            adicional2,
                                                                            adicional3,
                                                                            adicional4,
                                                                            adicional5)VALUES(
                                                                            :idCliente,
                                                                            :idCAL,
                                                                            :idProducto,
                                                                            :cantidad,
                                                                            :impTotal,
                                                                            :estadosTransaccion,
                                                                            :adicional1,
                                                                            :adicional2,
                                                                            :adicional3,
                                                                            :adicional4,
                                                                            :adicional5
                                                                            )");

        $stmt->bindParam(":idCliente",$datos["idCliente"],PDO::PARAM_INT);
        $stmt->bindParam(":idCAL",$datos["idCAL"],PDO::PARAM_STR);
        $stmt->bindParam(":idProducto",$datos["idProducto"],PDO::PARAM_INT);
        $stmt->bindParam(":cantidad",$datos["cantidad"],PDO::PARAM_STR);
        $stmt->bindParam(":impTotal",$datos["impTotal"],PDO::PARAM_STR);
        $stmt->bindParam(":estadosTransaccion",$datos["estadosTransaccion"],PDO::PARAM_STR);
        $stmt->bindParam(":adicional1",$datos["adicional1"],PDO::PARAM_STR);
        $stmt->bindParam(":adicional2",$datos["adicional2"],PDO::PARAM_STR);
        $stmt->bindParam(":adicional3",$datos["adicional3"],PDO::PARAM_STR);
        $stmt->bindParam(":adicional4",$datos["adicional4"],PDO::PARAM_STR);
        $stmt->bindParam(":adicional5",$datos["adicional5"],PDO::PARAM_STR);

        if ($stmt -> execute()) {
            $id = $db->lastInsertId();
            return $id;
        }else{
            return "error";
        }

        $stmt = null;
        $db= null;
    }

    static public function mdlVerPreTransaccion($data){

        $stmt = Conexion::conectar()->prepare("SELECT idCAL,idProducto,cantidad,impTotal,estadosTransaccion,adicional1,adicional2,adicional3,adicional4,adicional5 FROM tb_transaccion WHERE idTransaccion = :$data;");
        $stmt -> bindParam(":".$data,$data,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch();
        $stmt = null;
    }

    static public function mdlActualizarTransaccion($transaccion, $pedido){
        $stmt = Conexion::conectar()->prepare("UPDATE tb_transaccion SET visaETicket = :$pedido WHERE idTransaccion= :$transaccion;");
        $stmt -> bindParam(":".$transaccion,$transaccion,PDO::PARAM_STR);
        $stmt -> bindParam(":".$pedido,$pedido,PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        }else{
            return "error";
        }
        $stmt = null;
    }

    static public function mdlActualizaRespuestaVisa($transaccion, $data){

        $stmt = Conexion::conectar()->prepare(" UPDATE tb_transaccion
                                                SET                                         
                                                estadosTransaccion = :estadosTransaccion,
                                                visaRespuesta = :visaRespuesta,
                                                visaEstado = :visaEstado,
                                                visaCodAccion = :visaCodAccion,
                                                visaDscCodAccion = :visaDscCodAccion,
                                                visaPAN = :visaPAN,
                                                visaNomEmisor = :visaNomEmisor,
                                                visaECI = :visaECI,
                                                visaDescECI = :visaDescECI,
                                                visaCodAutor = :visaCodAutor,
                                                visaIdUnico = :visaIdUnico,
                                                visaImpAutorizado = :visaImpAutorizado,
                                                visaFechaHoraTx = :visaFechaHoraTx,
                                                visaDatoComercio = :visaDatoComercio
                                                WHERE idTransaccion = :$transaccion AND visaETicket = :visaETicket;");

        $stmt -> bindParam(":estadosTransaccion",$data["estadosTransaccion"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaRespuesta",$data["visaRespuesta"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaEstado",$data["visaEstado"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaCodAccion",$data["visaCodAccion"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaDscCodAccion",$data["visaDscCodAccion"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaPAN",$data["visaPAN"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaNomEmisor",$data["visaNomEmisor"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaECI",$data["visaECI"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaDescECI",$data["visaDescECI"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaCodAutor",$data["visaCodAutor"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaIdUnico",$data["visaIdUnico"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaImpAutorizado",$data["visaImpAutorizado"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaFechaHoraTx",$data["visaFechaHoraTx"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaDatoComercio",$data["visaDatoComercio"],PDO::PARAM_STR);
        $stmt -> bindParam(":visaETicket",$data["visaETicket"],PDO::PARAM_STR);
        $stmt -> bindParam(":".$transaccion,$transaccion,PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        }else{
            return "error";
        }
        $stmt = null;

    }

    static public function mdlUltimosPagos($cal){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM tb_transaccion WHERE idCAL = :cal ORDER BY idTransaccion DESC LIMIT 5;");
        $stmt -> bindParam(":cal",$cal,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetchAll();
        $stmt = null;

    }

    static public function mdlSumaUltPagos($cal, $id){

        $stmt = Conexion::conectar()->prepare("SELECT SUM(impTotal) AS 'suma' FROM tb_transaccion WHERE idCAL = :cal AND idProducto=:producto AND visaEstado='AUTORIZADO';");
        $stmt -> bindParam(":cal",$cal,PDO::PARAM_STR);
        $stmt -> bindParam(":producto",$id,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch();
        $stmt = null;

    }

}
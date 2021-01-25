<?php

class ModeloUsuarios
{

    static public function validarUsuario($username, $password)
    {

        //Se asigna el accessKey
        $accessKey = "ROYAL";

        //Se asigna la url del servicio
        $servicio = "http://200.48.20.156/SpringNet/ServiceSpring.asmx?wsdl";

        //Invocaci�n del web service
        $conf = array();
        //$conf["soap_version"]= SOAP_1_2;
        $conf["cache_wsdl"] = WSDL_CACHE_NONE;
        $client = new SoapClient($servicio, $conf);

        //parametros de la llamada
        $parametros = array();

        $parametros["AccessKey"]    = $accessKey;
        $parametros["Usuario"]      = $username;
        $parametros["Clave"]        = $password;

        //Aqui captura la cadena de resultado
        $result = $client->ValidarUsuario($parametros);

        $userData = $result->ValidarUsuarioResult;

        return $userData;
    }

    static public function apiEstadoHabilidad($numcal){
        
        $url = "http://servicioscal.org.pe/APICasilla/apiCasillas.php?isHabil=".$numcal;

        $json = file_get_contents($url);

		$datos = json_decode($json, true);

		return $datos;

    }

    // datos de agremiado
    static public function apiDatosAgremiado($numcal){
        
        $url = "http://servicioscal.org.pe/APICasilla/apiCasillas.php?numcal=".$numcal;

        $json = file_get_contents($url);

		$datos = json_decode($json, true);

		return $datos;

    }
}

?>
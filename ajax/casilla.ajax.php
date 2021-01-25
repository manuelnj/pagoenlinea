<?php

require_once "../controllers/pago.controlador.php";
require_once "../models/pago.modelo.php";

class AjaxPagos{

    public $persona;
    public $casilla;

    public function ajaxPrecioCasilla(){

        $p = trim($this->persona);
        
        $c = trim($this->casilla);

        $respuesta = ControladorPagos::ctrPrecioCasilla($p, $c);

        echo json_encode($respuesta);

    }

}

//**************************************************************

if (isset($_POST["persona"])) {
		
    $cartera = new AjaxPagos();
    $cartera -> persona = $_POST["persona"];
    $cartera -> casilla = $_POST["casilla"];
    $cartera -> ajaxPrecioCasilla();

}
<?php

class ControladorPagos{

    // funcion para traer los precios del producto
    static public function ctrConsultarPrecio($valor){

        $respuesta = ModeloPagos::mdlConsultarPrecio($valor);

        return $respuesta;
    }

    // obtener el tipo de cambio del sistema
    static public function ctrTipoCambio(){
        
        $respuesta = ModeloPagos::mdlTipoCambio();

        return $respuesta;
    }

    // numero de casillas obtenidas
    static public function ctrTotCasilla($data){
        
        $cantidad = ModeloPagos::mdlCantCasilla($data);

        return $cantidad;
    }

    // obtner las casillas del colegiado
    static public function ctrListarCasilla($data, $total){
       
        $respuesta = ModeloPagos::mdlListarCasilla($data, $total);

        return $respuesta;
    }

    // obtener el precio de la casilla
    static public function ctrPrecioCasilla($persona, $casilla){
        
        $respuesta = ModeloPagos::mdlPrecioCasilla($persona, $casilla);

        return $respuesta;
    }

    // generando la transaccion
    static public function ctrPreTransaccion(){
        
        if (isset($_POST["valorProducto"]) && strlen($_POST["valorProducto"])>0) {

            $tabla = "tb_transaccion";


            // validacion: si es pago de casilla, obtiene el valor 
            // del campo caso contrario se setea a null.
            if ($_POST["valorProducto"] == 4) {
                $casilla = $_POST["valorCasilla"];
            }else{
                $casilla = null;
            }

            // 
            if ($_POST["selDocumento"] == "FC") {
                $documento = trim($_POST["selDocumento"]).trim($_POST["valorRUC"]).trim(strtoupper($_POST["valorNombre"]));
                $domicilio = trim(strtoupper($_POST["valorDomicilio"]));
            }elseif ($_POST["selDocumento"] == "BV") {
                $documento = $_POST["selDocumento"];
                $domicilio = null;
            }

            $datos = array(
                            "idCliente" => $_POST["valorPersona"],
                            "idCAL" => $_SESSION["cal"],
                            "idProducto" => $_POST["valorProducto"],
                            "cantidad" => $_POST["selCuota"],
                            "impTotal" => $_POST["valorTotalImporte"],
                            "estadosTransaccion" => "C",
                            "adicional1" => $_POST["valorImpuesto"], //valor del impuesto
                            "adicional2" => $documento, // documento seleccionado, si es fc--> tipo|ruc|rason social
                            "adicional3" => 0, //descuento de 12 meses                       
                            "adicional4" => $domicilio, //domicilio fiscal si el tipo es ruc
                            "adicional5" => $casilla // si el producto es (4) obtiene el nro. de casilla.
            );

            $rpta = ModeloPagos::mdlPreTransaccion($tabla, $datos);

            if ($rpta!="error") {
                
                $_SESSION["idTransaccion"] = $rpta;

                echo '<script> window.location = "transaccion" </script>';

            }else{
                exit();
            }

            
            

        }else{
            // 
        }
    }

    // obtener datos de la transaccion
    static public function ctrVerPreTransaccion($data){

        $respuesta = ModeloPagos::mdlVerPreTransaccion($data);

        return $respuesta;
    }

    // actualizar el número de pedido y de la transaccion
    static public function ctrActualizarTransaccion($transaccion, $pedido){
        
        $respuesta = ModeloPagos::mdlActualizarTransaccion($transaccion, $pedido);

        return $respuesta;

    }

}
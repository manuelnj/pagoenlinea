<?php

class ControladorUsuarios
{

    static public function ctrIngresoUsuario()
    {

        if ((isset($_POST["ingUsuario"]) && !empty($_POST["ingUsuario"])) &&
            (isset($_POST["ingPassword"]) && !empty($_POST["ingPassword"]))
        ) {

            $uss = $_POST["ingUsuario"];
            $pwd = $_POST["ingPassword"];

            if ($uss != "00906") {
                exit();
            }

            $respuesta = ModeloUsuarios::validarUsuario($uss, $pwd);
            
            $persona = $respuesta->UsuarioId;
                        
            if ($persona != -1) {

                $colegiatura = $respuesta->Codigo;
                $nombres = $respuesta->Nombre . ' ' . $respuesta->Apellido;
                $data["productos"] = $respuesta->Productos;
               
                $_SESSION["iniciarSesion"] = "ok";
                $_SESSION["persona"] = $persona;
                $_SESSION["productos"] = $data["productos"];

                // estado de habilidad
                $apiEstHabilidad = ModeloUsuarios::apiEstadoHabilidad($colegiatura);
                $_SESSION["habilitado"] = $apiEstHabilidad["estado"];
                // fin
                
                // nombre de agremiado
                $apiAgremiado = ModeloUsuarios::apiDatosAgremiado($colegiatura);
                $_SESSION["nombres"] = $apiAgremiado["NOMBRES"];
                $_SESSION["cal"] = $apiAgremiado["CAL"];
                $_SESSION["envEmail"] = $apiAgremiado["EMAIL"];
                $_SESSION["envTipDoc"] = $apiAgremiado["ENVTIPO"];
                $_SESSION["envNroDoc"] = $apiAgremiado["ENVDOC"];

                echo '<script>
                        window.location = "inicio";
                     </script>';
                
            }else{

                echo '<br><div class="alert alert-danger">Usuario ó Contraseña incorrecta, vuelve a intentarlo</div>';
    
            }
        }
    }
}


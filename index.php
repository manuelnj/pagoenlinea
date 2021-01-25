<?php

date_default_timezone_set('America/Lima');

$secure = true;
$httponly = true; 
$samesite = 'None';

session_set_cookie_params('/; samesite='.$samesite, $secure, $httponly);

// session_set_cookie_params(["SameSite" => "None"]);
// session_set_cookie_params(["Secure" => "true"]);
// session_set_cookie_params(["HttpOnly" => "true"]);

// session_destroy();
session_start();

ini_set('date.timezone', 'America/Lima');

// config.
require_once "config/functions.php";

// controladores
require_once "controllers/plantilla.controlador.php";
require_once "controllers/usuario.controlador.php";
require_once "controllers/url.controlador.php";
require_once "controllers/pago.controlador.php";

// modelos
require_once "models/usuario.modelo.php";
require_once "models/pago.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();
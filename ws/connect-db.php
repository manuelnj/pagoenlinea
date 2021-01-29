<?php

// Configuración DB
// $server = '127.0.0.1';
// $db = 'cal_pagosweb';
// $user = 'visa';
// $pass = '';

//  Connect to Database
//  $connection = mysqli_connect($server, $user, $pass) 
//  or die ("Could not connect to server ... \n" . mysql_error ());
//  mysqli_select_db($db) 
//  or die ("Could not connect to database ... \n" . mysql_error ());
// mysqli_query("SET NAMES 'utf8'")
//  or die ("Could not connect to database ... \n" . mysql_error ());

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=cal_pagosweb","root","paraque");

		$link->exec("set names utf8");

		return $link;

	}

	static public function resultados($sql){

		$stmt = Conexion::conectar()->prepare($sql);

		$stmt->execute();

		return $stmt->fetchAll();	


	}

}



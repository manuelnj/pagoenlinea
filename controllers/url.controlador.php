<?php

class urlMaster{

    static public function obtenerurl(){

        $host = $_SERVER["HTTP_HOST"];
        $url  = $_SERVER["REQUEST_URI"];

        $urlMaster = "http://".$host.$url;

        $components = parse_url($urlMaster, PHP_URL_QUERY);
        //$component parameter is PHP_URL_QUERY
        parse_str($components, $results);
        
        return $results["id"];

    }
}
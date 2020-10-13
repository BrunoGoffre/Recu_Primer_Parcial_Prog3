<?php

require_once "Clases/token.php";
require_once "Clases/archivos.php";


use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? "";
$seccion = explode("/", $path)[1] ?? "";
$paramentro = explode("/", $path)[2] ?? "";
$headers = getallheaders();
$token = $headers['token'] ?? null;
$mensaje = "";

switch($seccion){
    case "Prueba":
        echo Token::GenerarToken("hola","user");
    break;
}

<?php

require_once "Clases/token.php";
require_once "Clases/archivos.php";
require_once "Clases/usuario.php";
require_once "Clases/Vehiculo.php";
require_once "Clases/servicio.php";


use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? "";
$seccion = explode("/", $path)[1] ?? "";
$paramentro = explode("/", $path)[2] ?? "";
$headers = getallheaders();
$token = $headers['token'] ?? null;
$mensaje = "";

switch ($seccion) {
    case "registro":
        if ($method == 'POST') {

            $email = $_POST['email'] ?? null;
            $tipo = $_POST['tipo'] ?? null;
            $pass = $_POST['password'] ?? null;
            $foto = $_FILES['foto'] ?? null;

            if ($email != null && $tipo != null && $pass != null && $foto != null) {
                if ($tipo == "admin" || $tipo == "user") {

                    $nuevoUsuario = new Usuario($email, $tipo, $pass, Usuario::CargarFotoUsuario('foto', "Fotos"));
                    if (Usuario::GuardarNuevoUsuario($nuevoUsuario)) {
                        $mensaje = "Guardado correctamente";
                    } else {
                        $mensaje = "Error al guardar, Mail registrado";
                    }
                } else {
                    $mensaje = "Seleccion un tipo de usuario valido";
                }
            }
        } else {
            $mensaje = "Metodo invalido";
        }
        echo $mensaje;
        break;
    case 'login':
        if ($method == 'POST') {

            $email = $_POST['email'] ?? null;
            $pass = $_POST['password'] ?? null;

            if ($email != null &&  $pass != null) {
                $user = new Usuario($email, "", $pass, "");
                $validado = Usuario::ValidarUsuario($user);

                if ($validado != null) {
                    $mensaje = Token::GenerarToken($validado->_email, $validado->_tipo);
                } else {
                    $mensaje = "Usuario inexsistente";
                }
            } else {
                $mensaje = "Error en los parametros";
            }
        } else {
            $mensaje = "Metodo invalido";
        }
        echo $mensaje;

        break;
    case 'vehiculo':
        if (Token::AutenticarToken($token) != false) {

            if ($method == 'POST') {

                $marca = $_POST['marca'] ?? null;
                $modelo = $_POST['modelo'] ?? null;
                $patente = $_POST['patente'] ?? null;
                $precio = $_POST['precio'] ?? null;

                if ($marca && $modelo && $patente && $precio) {
                    $nuevoVehiculo = new Vehiculo(strtolower($marca), strtolower($modelo), strtolower($patente), strtolower($precio));
                    if (Vehiculo::GuardarVehiculo($nuevoVehiculo)) {
                        $mensaje = "Guardado correctamente";
                    } else {
                        $mensaje = "Error al guardar";
                    }
                } else {
                    $mensaje = "Error en los parametros";
                }
            } else {
                $mensaje = "Metodo invalido";
            }
        } else {
            $mensaje = "Error de autenticacaion";
        }
        echo $mensaje;

        break;
    case 'patente':

        if (Token::AutenticarToken($token) != false) {

            if ($method == 'GET') {

                if ($paramentro != "") {
                    $vehiculo = Vehiculo::GetVehiculo($paramentro, "vehiculos.xxx");
                    if ($vehiculo) {
                        $mensaje = Vehiculo::MostrarVehiculo($vehiculo);
                    } else {
                        $mensaje = "No existe: $paramentro";
                    }
                } else {
                    $mensaje = "Error en los parametros";
                }
            } else {
                $mensaje = "Metodo invalido";
            }
        } else {
            $mensaje = "Error de autenticacaion";
        }
        echo $mensaje;

        break;
    case 'servicio':

        if (Token::AutenticarToken($token) != false) {

            if ($method == 'POST') {

                $id = $_POST['id'] ?? null;
                $tipo = $_POST['tipo'] ?? null;
                $precio = $_POST['precio'] ?? null;
                $demora = $_POST['demora'] ?? null;

                if ($id && $tipo && $precio && $demora) {
                    $nuevoServicio = new Servicio($id, $tipo, $precio, $demora);
                    if (Servicio::GuardarServicio($nuevoServicio)){
                        $mensaje = "Guardado con exito";
                    }else{
                        $mensaje = "Error al guardar";
                    }
                } else {
                    $mensaje = "Error en los parametros";
                }
            } else {
                $mensaje = "Metodo invalido";
            }
        } else {
            $mensaje = "Error de autenticacaion";
        }
        echo $mensaje;

        break;
}

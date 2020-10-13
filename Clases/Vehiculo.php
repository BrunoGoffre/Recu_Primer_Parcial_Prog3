<?php

class Vehiculo
{
    var $_marca;
    var $_modelo;
    var $_patente;
    var $_precio;

    public function __construct($marca, $modelo, $patente, $precio)
    {
        $this->_marca = $marca;
        $this->_modelo = $modelo;
        $this->_patente = $patente;
        $this->_precio = $precio;
    }

    public static function GuardarVehiculo($auto)
    {
        $retorno = true;


        if (!Vehiculo::isInVehiculos($auto, "vehiculos.xxx")) {

            if (isset($auto)) {
                if (!Archivos::GuardaJson("vehiculos.xxx", $auto)) {
                    $retorno = false;
                }
            } else {
                $retorno = false;
            }
        } else {
            $retorno = false;
            echo "Patente Existente<br>";
        }
        return $retorno;
    }
    public static function isInVehiculos($auto, $ruta)
    {
        $autos = Archivos::TraerJson($ruta);
        if (isset($autos)) {

            foreach ($autos as $valor) {
                if ($valor->_patente == $auto->_patente) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    public static function GetVehiculo($parametro, $ruta)
    {
        $autos = Archivos::TraerJson($ruta);

        foreach ($autos as $valor) {
            if ($valor->_patente === $parametro || $valor->_marca === $parametro || $valor->_modelo === $parametro) {
                return $valor;
            }
        }
        return false;
    }

    public static function MostrarVehiculo($auto)
    {
        $mensaje = "";
        if ($auto != null) {
            $mensaje = "Marca: $auto->_marca Modelo: $auto->_modelo Patente: $auto->_patente Precio: $auto->_precio";
        } else {
            $mensaje = null;
        }
        return $mensaje;
    }
}

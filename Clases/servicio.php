<?php

class Servicio
{
    var $_id;
    var $_tipo;
    var $_precio;
    var $_demora;

    public function __construct($id, $tipo, $precio, $demora)
    {
        $this->_id = $id;
        if ($tipo == "10.000km" || $tipo == "20.000km" ||$tipo == "50.000km" ){
            $this->_tipo = $tipo;
        }else{
            $this->_tipo = "10.000km";
        }
        $this->_precio = $precio;
        $this->_demora = $demora;
    }

    public static function GuardarServicio($servicio)
    {
        $retorno = false;
        if ($servicio != null){

           $retorno = Archivos::GuardaJson("tipoServicio.xxx", $servicio);
        }
        return $retorno;
    }
}
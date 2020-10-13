<?php

class Auto{
    var $_patente;
    var $_fecha;
    var $_email;
    var $_fecha_egreso;
    var $_importe;

    public function __construct($patente,$email,$fechaEgreso=null,$importe=null){
        $this->_patente = $patente;
        $this->_fecha = date("jS \of F Y");
        $this->_email = $email;
        $this->_fecha_egreso = $fechaEgreso;
        $this->_importe = $importe;
    }

    public static function ObtenerMail($array){
        foreach ($array as $key => $value) {
            if ($key == "email"){
                return $value;
            }
        }
        return null;
    }
    public static function MostrarAutos(){
        $autos = Archivos::TraerJson("autos.xxx");
        sort($autos,1);
        foreach ($autos as $value) {
            Echo "<br>Patente: $value->_patente Fecha: $value->_fecha Email: $value->_email";
            //timesStamp ordenar.
        }
    }
    public static function MostrarEgreso($patente){
        $autos = Archivos::TraerJson("autos.xxx");
        foreach ($autos as $value) {
            if ($value->_patente == $patente){
                $value->_fechaEgreso = date("jS \of F Y");
                Archivos::GuardaJson("autos.xxx",$autos);                
                break;  
            }else{
                return "Patente no encontrada";
            }   
        }
        $autos = Archivos::TraerJson("autos.xxx");
        foreach($autos as $value){
            if ($value->_patente == $patente){
            return "Importe:$10 Patente:$value->_patente Fecha Ingreso:$value->_fechaIngreso Fecha Egreso:$value->_fechaEgreso";
            }
        }
    }
    public static function ValorEstadia($patente){
        $autos = Archivos::TraerJson("autos.xxx");
        foreach ($autos as $value) {
            if ($value->_patente == $patente){
                
                return "";
            }else{
                return "Patente no encontrada";
            }   
        }
    }
}

    
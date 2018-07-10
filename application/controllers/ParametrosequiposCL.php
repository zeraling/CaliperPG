<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of ParametrosequiposCL
 *
 * @author Usuario
 */
class ParametrosequiposCL {

    //put your code here

    private $serviceData;

    public function __construct() {
        $parametrosService = new \Application\Access\ParametrosequiposDA;
        return $this->serviceData = $parametrosService;
    }

    public function __destruct() {
        $this->serviceData;
    }

    public function ConsultaParametrosEquipo($param) {
        try {
            $accion = $this->serviceData->ParametrosEquipos($param);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function AgregarParametrosEquipo($tipo, $params) {
        $regParam = 0;
        foreach ($params as $value) {
            $carga = $this->serviceData->AgregarParametro($tipo, $value);
            $carga ? $regParam = $regParam + 1 : 0;
        }
        return $regParam;
    }

    public function ActualziarParametrosEquipo($tipo, $params) {
        $regParam = 0;
        $parametros = $this->serviceData->ParametrosEquipos($tipo,true);
        $arrayP=(explode(',', trim($parametros->arrayparams, '{}')));

        foreach ($params as $value) {
            if(!in_array($value, $arrayP)){
                echo 'quere agregar'.$value.' -';
                $cargado=$this->serviceData->ParametroEnEquipo($value);
                $carga = !empty($cargado)?$this->serviceData->RetirarParametro($tipo, $value):$this->serviceData->AgregarParametro($tipo, $value);
                $carga ? $regParam = $regParam + 1 : 0;
            }else{
                unset($arrayP[$value]);
                $arrayP = array_values(array_filter($arrayP));
            }
        }
        var_dump($arrayP);
        return $regParam;
    }

}

<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\CustomFunctions;

/**
 * Description of ParametrosequiposCL
 *
 * @author Usuario
 */
class ParametrosequiposCL extends CustomFunctions {

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
            $accion = $this->serviceData->ParametrosEquipo($param);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaParametrosEquipos($param) {
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
        $parametros = $this->serviceData->ParametrosEquipo($tipo, true);
        $arrayCargar = $params;
        $arrayCargados = (explode(',', trim($parametros->arrayparams, '{}')));

        foreach ($params as $value) {
            if (in_array($value, $arrayCargados)) {
                $arrayCargados = parent::removeElementArray($value, $arrayCargados);
                $arrayCargar = parent::removeElementArray($value, $arrayCargar);
            }
        }

        foreach ($arrayCargar as $value) {
            $carga = $this->serviceData->AgregarParametro($tipo, $value);
            $carga ? $regParam = $regParam + 1 : 0;
        }

        foreach ($arrayCargados as $value) {
            $this->serviceData->RetirarParametro($tipo, $value);
        }
        return $regParam;
    }
    
    public function RetirarParametrosEquipo($tipo) {
        $regParam = 0;
        $parametros = $this->serviceData->ParametrosEquipo($tipo, true);
        $arrayCargados = (explode(',', trim($parametros->arrayparams, '{}')));
        foreach ($arrayCargados as $value) {
            $this->serviceData->RetirarParametro($tipo, $value);
        }
        return $regParam;
    }

}

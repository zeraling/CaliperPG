<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of ParametrospatronesCL
 *
 * @author Usuario
 */
class ParametrospatronesCL {

    //put your code here

    private $serviceData;

    function __construct() {
        $calibracionService = new \Application\Access\ParametrospatronesDA();
        $this->serviceData = $calibracionService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ConsultaParametrosPatron($patron) {
        try {
            $aciion = $this->serviceData->ParametrosPatron($patron);
            return $aciion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function AsignarParametroPatron(\Application\Data\ParametrospatronesVO $param) {
        try {
            $aciion = $this->serviceData->AsignarParametro($param);
            return $aciion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function EliminarParametroAsignado($param) {
        try {
            $aciion = $this->serviceData->EliminarParametro($param);
            return $aciion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    

    
    
}

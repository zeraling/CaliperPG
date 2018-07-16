<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of CalibracionpatronesCL
 *
 * @author Usuario
 */
class CalibracionpatronesCL {
    //put your code here
    
    private $serviceData;

    function __construct() {
        $calibracionService = new \Application\Access\CalibracionpatronesDA();
        $this->serviceData = $calibracionService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ConsultaCalibracionesPatron($patron) {
        try {
            $accion = $this->serviceData->CalibracionesPatron($patron);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function RegistrarFecha(\Application\Data\CalibracionpatronesVO $calibracion) {
        try {
            $accion = $this->serviceData->Registrar($calibracion);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ConsultaFechasNull($patron) {
        try {
            $accion = $this->serviceData->FechasNull($patron);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function InactivarFechasPatron($patron,$actual) {
        try {
            $accion = $this->serviceData->InactivarFechas($patron,$actual);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
}

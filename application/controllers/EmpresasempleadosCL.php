<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of CargosCL
 *
 * @author Usuario
 */
class EmpresasempleadosCL {

    private $serviceData;

    function __construct() {
        $EmpresasService = new \Application\Access\EmpresasempleadosDA();
        $this->serviceData = $EmpresasService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ConsultaAsignaciones($empleado) {
        try {
            $accion = $this->serviceData->Asignaciones($empleado);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ConsultaEmpresasAsignadas($empleado) {
        try {
            $accion = $this->serviceData->EmpresasAsignadas($empleado);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function EliminarAsignacion($empleado) {
        try {
            $accion = $this->serviceData->Eliminar($empleado);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function RegistrarEmpleado($empleado,$empresa) {
        try {
            $accion = $this->serviceData->Registrar($empleado,$empresa);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

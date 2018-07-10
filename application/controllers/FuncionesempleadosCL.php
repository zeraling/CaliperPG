<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\FuncionesempleadosDA;

//use Application\Data\FuncionesempleadosVO;

/**
 * Description of FuncionesempleadosCL
 *
 * @author Usuario
 */
class FuncionesempleadosCL {

    private $serviceData;

    function __construct() {
        $FuncionesempleadosService = new FuncionesempleadosDA();
        $this->serviceData = $FuncionesempleadosService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ConsultaPermisosAsignados($user) {
        try {
            $consulta = $this->serviceData->PermisosAsignados($user);
            return $consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function PermisosUsuario($user) {
        try {
            $Consulta = $this->serviceData->ListaPermisos($user);
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function AsignarPermisos($funcion, $empleado) {
        try {
            $accion = $this->serviceData->AsignarPermisos($funcion, $empleado);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function BorrarPermisos($funcion, $empleado) {
        try {
            $Consulta = $this->serviceData->Borrar($funcion, $empleado);
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

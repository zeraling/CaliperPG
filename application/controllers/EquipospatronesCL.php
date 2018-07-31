<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\CustomFunctions;

/**
 * Description of EquipospatronesCL
 *
 * @author Usuario
 */
class EquipospatronesCL {

    private $serviceData;

    function __construct() {
        $EquiposService = new \Application\Access\EquipospatronesDA();
        $this->serviceData = $EquiposService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ListadoPatrones() {
        try {
            $Consulta = $this->serviceData->Listado();
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ConsultaDetallesPatron($patron) {
        try {
            $Consulta = $this->serviceData->DetallesPatron($patron);
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function VerificarUnEquipo($param) {
        try {
            $accion = $this->serviceData->EquipoEspecifico($param);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function RegistrarEquipo(\Application\Data\EquipospatronesVO $equipo) {
        try {
            $Guardar = $this->serviceData->Registrar($equipo);
            return $Guardar;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaUnEquipo($producto) {
        try {
            $equipo1 = $this->serviceData->UnEquipo($producto);
            return $equipo1;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

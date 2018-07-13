<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\CustomFunctions;

/**
 * Description of ProductosCL
 *
 * @author Usuario
 */
class EquiposCL extends CustomFunctions {

    private $serviceData;

    function __construct() {
        $EquiposService = new \Application\Access\EquiposDA();
        $this->serviceData = $EquiposService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ConsultaEquipos($data) {
        $condiciones = " ";
        try {
            $condiciones .= $data->tipo > 0 ? " AND equipos.id_tipo=" . $data->tipo : "";
            $condiciones .= $data->marca > 0 ? " AND equipos.id_marca=" . $data->marca : "";
            $condiciones .= $data->modelo !='' ? " AND equipos.modelo='" . $data->modelo."'" : "";

            $Consulta = $this->serviceData->Consulta($condiciones);
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function VerificarUnEquipo(\Application\Data\EquiposVO $param) {
        try {
            $accion = $this->serviceData->EquipoEspecifico($param);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function RegistrarEquipo(\Application\Data\EquiposVO $equipo) {
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

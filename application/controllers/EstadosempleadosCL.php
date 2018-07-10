<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\EstadosempleadosDA;

/**
 * Description of EstadosempleadosCL
 *
 * @author Usuario
 */
class EstadosempleadosCL {

    private $serviceData;

    function __construct() {
        $EstadosempleadosService = new EstadosempleadosDA();
        $this->serviceData = $EstadosempleadosService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ListaEstado() {
        try {
            $lista = $this->serviceData->Lista();
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaEmpleados($data) {
        $condiciones = "";
        try {
            $condiciones .= $data->estado > 0 ? " AND empleados.id_estado=" . $data->estado : "";
            $condiciones .= $data->cargo > 0 ? " AND empleados.id_cargo=" . $data->cargo . "" : "";
            $condiciones .= $data->codigo > 0 ? " AND empleados.cedula=" . $data->codigo : "";

            $Consulta = $this->serviceData->Consulta($condiciones);
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function RestablecerPws($cedulaRed) {
        try {
            $ejec = $this->serviceData->ResetPsw($cedulaRed);
            return $ejec;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function CambiarEstado($empleado, $estado) {
        try {
            $ejec = $this->serviceData->Estado($empleado, $estado);
            return $ejec;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\EmpleadosDA;

/**
 * Description of EmpleadosCL
 *
 * @author Usuario
 */
class EmpleadosCL {

    private $serviceData;

    function __construct() {
        $EmpleadosService = new EmpleadosDA();
        $this->serviceData = $EmpleadosService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function encryptKey($string, $key) {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    public function ConsultaEmpleadoSesion($id) {
        try {
            $ListaEmpleados = $this->serviceData->EmpleadoSesion($id);
            return $ListaEmpleados;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaDetallesEmpleado($id) {
        try {
            $ListaEmpleados = $this->serviceData->DetallesEmpleado($id);
            return $ListaEmpleados;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ActualarPws($output1, $cedula) {
        try {
            $eject = $this->serviceData->Psw($output1, $cedula);
            return $eject;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaUnEmpleado($id) {
        try {
            $usuario1 = $this->serviceData->UnEmpleado($id);
            return $usuario1;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function GuardarEmpleado(\Application\Data\EmpleadosVO $usuarios) {
        try {
            $Guardar = $this->serviceData->Guardar($usuarios);
            return $Guardar;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ActualizarEmpleado(\Application\Data\EmpleadosVO $usuarios) {
        try {
            $actualiza = $this->serviceData->Actualizar($usuarios);
            return $actualiza;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ListaEmpleados() {
        try {
            $Consulta = $this->serviceData->Lista();
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ListaEmpleadosActivos() {
        try {
            $Consulta = $this->serviceData->ListaActivos();
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

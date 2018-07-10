<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Access;

use PDO;
use PDOException;
use Application\Connections\CaliperDB;
use Application\AppLog;

/**
 * Description of EstadosempleadosDA
 *
 * @author Usuario
 */
class EstadosempleadosDA {

    public function Lista() {
        $consulta = "SELECT * FROM estadosempleados";
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute();
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Consulta($param) {
        $consulta = "select 
            empleados.cedula,
            empleados.nombres,
            empleados.apellidos,
            cargos.nombre as cargo,
            empleados.id_estado,
            estadosempleados.nombre as estado
            from empleados,estadosempleados,cargos
            where cargos.codigo=empleados.id_cargo
            and estadosempleados.codigo=empleados.id_estado
            " . $param;

        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute();
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function ResetPsw($cedula) {
        $sql = 'UPDATE empleados SET clave_acceso=:claveBase,estado_clave=false WHERE empleados.cedula=:usuario';
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($sql);
            $query->bindValue(':usuario', $cedula, PDO::PARAM_INT);
            $query->bindValue(':claveBase', '$2y$10$hYWi9Bu7afP5Npd4tP2meuVhskSQ7ahUfzv43Mz6pVGqRy/xXaE5O', PDO::PARAM_STR);

            // ejecutar la consulta
            $eject = $query->execute();
            // devolvemos el estado del resultado de la consulta
            return $eject;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return false;
        }
    }

    public function Estado($cedula, $estado) {
        $sql = 'UPDATE empleados SET clave_acceso=:claveBase,estado_clave=false,id_estado=:estado WHERE empleados.cedula=:usuario';
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($sql);
            $query->bindValue(':usuario', $cedula, PDO::PARAM_INT);
            $query->bindValue(':estado', $estado, PDO::PARAM_INT);
            $query->bindValue(':claveBase', '$2y$10$hYWi9Bu7afP5Npd4tP2meuVhskSQ7ahUfzv43Mz6pVGqRy/xXaE5O', PDO::PARAM_STR);
            // ejecutar la consulta
            $eject = $query->execute();
            // devolvemos el estado del resultado de la consulta
            return $eject;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return false;
        }
    }

}

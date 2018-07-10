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
 * Description of CargosDA
 *
 * @author Usuario
 */
class EmpresasempleadosDA {

    
    public function Asignaciones($empleado) {
        $consulta = "SELECT 
        array_to_string(
        array(
            SELECT empresas.codigo
            FROM empresas,empleadosempresas 
            WHERE empleadosempresas.cod_empresa=empresas.codigo 
            and empleadosempresas.id_empleado=".$empleado."
        ),',') AS asignadas";
        //instancia y conexion a base de datos

        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->query($consulta);
            //establecer el tipo de retorno de los datos
            $resultados = $query->fetch(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }
    
    
    
    //SELECT SIN PARAMETROS
    public function EmpresasAsignadas($empleado) {
        $consulta = "SELECT 
        empresas.codigo,
        empresas.nombre,
        empleadosempresas.codigo as asign
        FROM empresas 
            LEFT JOIN empleadosempresas 
            ON empleadosempresas.cod_empresa=empresas.codigo 
            and empleadosempresas.id_empleado=:empleado";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->execute([':empleado'=>$empleado]);
            //establecer el tipo de retorno de los datos
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Eliminar($empleado) {
        $consulta = "DELETE FROM empleadosempresas WHERE id_empleado=?";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(1, $empleado);
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

    public function Registrar($empleado, $empresa) {
        $consulta = "INSERT INTO empleadosempresas(cod_empresa,id_empleado)VALUES(?,?)";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindParam(1, $empresa, PDO::PARAM_INT);
            $query->bindParam(2, $empleado);
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

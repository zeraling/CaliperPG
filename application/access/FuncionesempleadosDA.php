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
 * Description of FuncionesempleadosDA
 *
 * @author Usuario
 */
class FuncionesempleadosDA {

    public function PermisosAsignados($user) {
        $consulta = "SELECT 
        funcionessistema.codigo,
        funcionessistema.nombre,
        funcionessistema.cod_modulo,
        CASE 
            WHEN funcionesempleados.id >0 then 1
            WHEN funcionesempleados.id is null then 0
        END AS estado
        FROM funcionessistema 
            LEFT JOIN funcionesempleados 
            ON funcionesempleados.cod_funcion=funcionessistema.codigo
            AND  funcionesempleados.id_empleado=:empleado
        ORDER BY funcionessistema.codigo";

        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':empleado'=>$user]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function ListaPermisos($user) {
        $consulta = "select 
        funcionesempleados.id,
        funcionesempleados.cod_funcion,
        funcionessistema.nombre
        from funcionesempleados,funcionessistema,empleados
        where funcionesempleados.cod_funcion=funcionessistema.codigo
        and funcionesempleados.id_empleado=empleados.cedula
        and empleados.cedula=:empleado
        order by funcionesempleados.cod_funcion";

        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':empleado'=>$user]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function AsignarPermisos($funcion, $empleado) {

        $consulta = "INSERT INTO funcionesempleados(cod_funcion,id_empleado,fecha_asignacion)"
                . "values(:funcion,:usuario,current_timestamp)";

        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':funcion',$funcion);
            $query->bindValue(':usuario',$empleado);
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

    public function Borrar($funcion, $empleado) {

        $consulta = "DELETE FROM funcionesempleados "
                . "WHERE funcionesempleados.id_empleado=:usuario "
                . "AND funcionesempleados.cod_funcion=:funcion";
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':usuario',$empleado);
            $query->bindValue(':funcion',$funcion);
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

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
 * Description of ModulossistemaDA
 *
 * @author Usuario
 */
class ModulossistemaDA {

    public function Lista() {
        $consulta = "SELECT modulossistema.codigo,modulossistema.nombre FROM modulossistema";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->query($consulta);
            //establecer el tipo de retorno de los datos
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function PermisosModulo($modulo) {
        $consulta = "SELECT 
        funcionessistema.codigo,
        funcionessistema.nombre,
        funcionessistema.descripcion,
        funcionessistema.cod_modulo,
        modulossistema.nombre as modulo
        FROM funcionessistema,modulossistema 
        WHERE funcionessistema.cod_modulo=modulossistema.codigo
        and funcionessistema.cod_modulo=:modulo
        order by funcionessistema.cod_modulo asc";

        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':modulo' => $modulo]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

}

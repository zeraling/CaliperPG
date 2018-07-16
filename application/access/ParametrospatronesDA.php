<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Access;

use PDO;
use PDOException;
use Application\Connections\CaliperDB;
use Application\AppLog;

/**
 * Description of ParametrospatronesDA
 *
 * @author Usuario
 */
class ParametrospatronesDA {

    //put your code here

    public function ParametrosPatron($patron) {
        $consulta = 'select 
        parametrospatrones.id,
        parametrospatrones.cod_patron,
        parametros.nombre as parametro,
        unidadesparametros.nombre as unidad,
        parametrospatrones.resolucion,
        parametrospatrones.incertidumbre,
        parametrospatrones.valor_tolerancia,
        parametrospatrones.unidad_tolerancia
        from equipospatrones,parametrospatrones,parametros,unidadesparametros
        where equipospatrones.codigo=parametrospatrones.cod_patron
        and parametros.id=parametrospatrones.id_parametro
        and unidadesparametros.id=parametrospatrones.id_unidad
        and parametrospatrones.cod_patron=:patron';
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':patron' => $patron]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function AsignarParametro(\Application\Data\ParametrospatronesVO $param) {
        $consulta = "insert into parametrospatrones(cod_patron,cod_prueba,id_parametro,id_unidad,incertidumbre,resolucion,valor_tolerancia,unidad_tolerancia)"
                . "values(:patron,:prueba,:parame,:unidad,:up,:res,:tole,:unit)";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);

            $query->bindValue(':patron', $param->getCod_patron(), PDO::PARAM_INT);
            $query->bindValue(':prueba', $param->getCod_prueba(), PDO::PARAM_INT);
            $query->bindValue(':parame', $param->getId_parametro());
            $query->bindValue(':unidad', $param->getId_unidad());
            $query->bindValue(':up', $param->getIncertidumbre());
            $query->bindValue(':res', $param->getResolucion());
            $query->bindValue(':tole', $param->getValor_tolerancia());
            $query->bindValue(':unit', $param->getUnidad_tolerancia(), PDO::PARAM_STR);
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

    public function EliminarParametro($param) {
        $consulta = 'delete from parametrospatrones where parametrospatrones.id=:code';
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $eject = $query->execute([':code'=>$param]);
            // devolvemos el estado del resultado de la consulta
            return $eject;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return false;
        }
    }

}

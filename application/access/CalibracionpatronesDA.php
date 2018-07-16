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
 * Description of CalibracionpatronesDA
 *
 * @author Usuario
 */
class CalibracionpatronesDA {

    //put your code here

    public function CalibracionesPatron($patron) {
        $consulta = "select * from calibracionpatrones where calibracionpatrones.cod_patron=:patron";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->execute([':patron' => $patron]);
            //establecer el tipo de retorno de los datos
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

     public function FechasNull($patron) {
        $consulta = "select calibracionpatrones.codigo 
        from calibracionpatrones 
        where calibracionpatrones.cod_patron=:patron
        and calibracionpatrones.aplica=false";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->execute([':patron' => $patron]);
            //establecer el tipo de retorno de los datos
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }
    
    public function Registrar(\Application\Data\CalibracionpatronesVO $calibra) {
        $consulta = "insert into calibracionpatrones (cod_patron,fecha_actual,fecha_proxima,estado,aplica)values(:patron,:actual,:proxima,:estado,:aplica)";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':patron', $calibra->getCod_patron(), PDO::PARAM_INT);
            $query->bindValue(':actual', $calibra->getFecha_actual());
            $query->bindValue(':proxima', $calibra->getFecha_proxima());
            $query->bindValue(':estado', $calibra->getEstado(), PDO::PARAM_INT);
            $query->bindValue(':aplica', $calibra->getAplica(), PDO::PARAM_BOOL);
            // ejecutar la consulta
            $query->execute();
            // devolvemos el ultimo identificador insertado
            $identidad = $dataBase->lastInsertId();
            return $identidad;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function InactivarFechas($patron,$actual) {
        $consulta = "update calibracionpatrones set estado=false where calibracionpatrones.codigo!=:actual and calibracionpatrones.cod_patron=:patron";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':actual',$actual);
            $query->bindValue(':patron',$patron);
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

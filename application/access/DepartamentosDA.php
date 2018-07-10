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
 * Description of DepartamentosDA
 *
 * @author Usuario
 */
class DepartamentosDA {

    public function Lista() {
        $consulta = "SELECT * FROM departamentos";
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
}
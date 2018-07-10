<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Access;

use PDO;
use PDOException;
use Application\Connections\GnesisDB;
use Application\AppLog;

/**
 * Description of FuncionessistemaDA
 *
 * @author Usuario
 */
class FuncionessistemaDA {

    public function Lista() {
        $consulta = "SELECT 
            FUNCIONESSISTEMA.Codigo,
            FUNCIONESSISTEMA.Nombre,
            FUNCIONESSISTEMA.Descripcion,
            MODULOSSISTEMA.Nombre as Tipo
            FROM FUNCIONESSISTEMA,MODULOSSISTEMA 
            WHERE FUNCIONESSISTEMA.CodModulo=MODULOSSISTEMA.Codigo
            ORDER BY MODULOSSISTEMA.Codigo ASC";
        $dataBase = new GnesisDB();
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

    public function UnaFuncion($id) {
        $consulta = "SELECT * FROM FUNCIONESSISTEMA WHERE FUNCIONESSISTEMA.Codigo=" . $id;
        $dataBase = new GnesisDB();
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

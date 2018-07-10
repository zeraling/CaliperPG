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
 * Description of MarcasDA
 *
 * @author Usuario
 */
class MarcasDA {

    public function Lista() {
        $consulta = "SELECT * FROM MARCAS ORDER BY MARCAS.Nombre ASC";
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

    public function UnaMarca($id) {

        $consulta = 'SELECT * FROM MARCAS WHERE MARCAS.Codigo=:codigo';
        $dataBase = new GnesisDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':codigo'=>$id]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Verificar($marca) {

        $consulta = 'SELECT * FROM MARCAS WHERE MARCAS.Nombre=:nombre';
        $dataBase = new GnesisDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':nombre'=>$marca]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Agregar(\Application\Data\MarcasVO $marca) {

        $consulta = "INSERT INTO MARCAS(Nombre)VALUES(:nombre)";
        //instancia y conexion a base de datos
        $dataBase = new GnesisDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':nombre', $marca->getNombre(),PDO::PARAM_STR);
            // ejecutar la consulta
            $query->execute();
            // devolvemos el ultimo identificador insertado
            $identidad = $dataBase->lastInsertId('MARCAS');
            return $identidad;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Actualizar(\Application\Data\MarcasVO $marca) {
        $consulta = "UPDATE MARCAS SET Nombre=:nombre WHERE MARCAS.Codigo=:codigo";
        $dataBase = new GnesisDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':codigo', $marca->getCodigo(),PDO::PARAM_INT);
            $query->bindValue(':nombre', $marca->getNombre(),PDO::PARAM_STR);
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

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
 * Description of EquipospatronesDA
 *
 * @author Usuario
 */
class EquipospatronesDA {

    public function Listado() {
        $consulta = "select 
        equipospatrones.codigo,
        equipospatrones.nombre ||' '|| marcas.nombre||' '|| equipospatrones.modelo as descripcion,
        equipospatrones.serie
        from equipospatrones,marcas
        where equipospatrones.id_marca=marcas.codigo";
        //instancia y conexion a base de datos
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

    public function EquipoEspecifico($param) {
        $consulta = "select equipospatrones.codigo from equipospatrones where equipospatrones.serie=:serie";

        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':serie' =>$param]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Registrar(\Application\Data\EquipospatronesVO $producto) {
        $consulta = "insert into equipospatrones(nombre,id_marca,modelo,serie)values(:nombre,:marca,:modelo,:serie)";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);

            $query->bindValue(':nombre', $producto->getNombre(), PDO::PARAM_STR);
            $query->bindValue(':marca', $producto->getId_marca(), PDO::PARAM_INT);
            $query->bindValue(':modelo', $producto->getModelo(), PDO::PARAM_STR);
            $query->bindValue(':serie', $producto->getModelo(), PDO::PARAM_STR);

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

    public function UnEquipo($codigo) {
        $consulta = "select * from equipospatrones where equipospatrones.codigo=:codeigo";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':codeigo' => $codigo]);
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

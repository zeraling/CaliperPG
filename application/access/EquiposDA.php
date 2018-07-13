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
 * Description of ProductosDA
 *
 * @author Usuario
 */
class EquiposDA {

    public function Consulta($param) {
        $consulta = "select 
        equipos.codigo,
        equipos.id_tipo,
        tiposequipos.nombre as tipo,
        marcas.nombre as marca,
        equipos.modelo
        from equipos,tiposequipos,marcas
        where equipos.id_marca=marcas.codigo
        and equipos.id_tipo=tiposequipos.id
        " . $param;
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

    public function EquipoEspecifico(\Application\Data\EquiposVO $param) {
        $consulta = "select equipos.codigo from equipos "
                . "where equipos.id_marca=:marca and equipos.id_tipo=:tipo and equipos.modelo=:modelo";

        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([
                ':marca' => $param->getId_marca(),
                ':modelo' => $param->getModelo(),
                ':tipo' => $param->getId_tipo()
            ]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Registrar(\Application\Data\EquiposVO $producto) {
        $consulta = "insert into equipos(id_tipo,id_marca,modelo)values(:tipo,:marca,:modelo)";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);

            $query->bindValue(':tipo', $producto->getId_tipo(), PDO::PARAM_INT);
            $query->bindValue(':marca', $producto->getId_marca(), PDO::PARAM_INT);
            $query->bindValue(':modelo', $producto->getModelo(), PDO::PARAM_STR);

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
        $consulta = "select * from equipos where equipos.codigo=:codeigo";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':codigo' => $codigo]);
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

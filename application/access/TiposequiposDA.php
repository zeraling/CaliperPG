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
 * Description of TiposequiposDA
 *
 * @author Usuario
 */
class TiposequiposDA {

    public function Verificar($nombre) {
        $consulta = 'SELECT * FROM tiposequipos WHERE tiposequipos.nombre=:nombre';
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':nombre' => $nombre]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Agregar($nombre,$tipo) {
        $consulta = "INSERT INTO tiposequipos(nombre,categoria)VALUES(:nombr,:categoria)";
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':nombr', $nombre, PDO::PARAM_STR);
            $query->bindValue(':categoria', $tipo, PDO::PARAM_STR);
            // ejecutar la consulta
            $query->execute();
            $identidad = $dataBase->lastInsertId();
            // devolvemos el estado del resultado de la consulta
            return $identidad;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Actualizar($id, $nombre) {
        $consulta = "UPDATE tiposequipos SET nombre=:nombr WHERE tiposequipos.id=:code";
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':code', $id);
            $query->bindValue(':nombr', $nombre, PDO::PARAM_STR);

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

     public function UnTipo($id) {
        $consulta = "SELECT * FROM tiposequipos WHERE tiposequipos.id=:codigo";
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':codigo' => $id]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }
    
    public function ConsultaGeneral() {
        $consulta = "select 
        tiposequipos.id,
        tiposequipos.nombre,
        tiposequipos.categoria,
        count(parametrosequipos.id_tipoequipo) as cantidad
        from tiposequipos
            left join parametrosequipos 
            on parametrosequipos.id_tipoequipo=tiposequipos.id
        group by tiposequipos.id,tiposequipos.nombre,tiposequipos.categoria";
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

    public function ConsultaEquipos() {
        $consulta = "select 
        tiposequipos.id,
        tiposequipos.nombre
        from tiposequipos
        where tiposequipos.categoria='equipo'";
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

    
    public function EquiposPorTipo($tipo) {
        $consulta = "select 
        equipos.codigo,
        tiposequipos.nombre ||' '|| marcas.nombre||' '|| equipos.modelo as descripcion,
        equipos.serie
        from tiposequipos,equipos,marcas
        where equipos.id_marca=marcas.codigo
        and tiposequipos.id=equipos.id_tipo
        and tiposequipos.id=:tipo";
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':tipo' => $tipo]);
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

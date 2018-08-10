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

    public function EquipoEspecifico($serie) {
        $consulta = "select equipos.codigo from equipos where equipos.serie=:serie";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':serie' =>$serie]);
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
        $consulta = "insert into equipos(id_tipo,id_marca,modelo,serie)values(:tipo,:marca,:modelo,:serie)";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);

            $query->bindValue(':tipo', $producto->getId_tipo(), PDO::PARAM_INT);
            $query->bindValue(':marca', $producto->getId_marca(), PDO::PARAM_INT);
            $query->bindValue(':modelo', $producto->getModelo(), PDO::PARAM_STR);
            $query->bindValue(':serie', $producto->getSerie(), PDO::PARAM_STR);

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
        $consulta = "select * from equipos where equipos.codigo=:codigo";
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
    
    public function Info($param) {
        $consulta = "select 
        equipos.codigo,
        tiposequipos.nombre as tipo,
        marcas.nombre as marca,
        equipos.modelo,
        equipos.serie
        from equipos,tiposequipos,marcas
        where equipos.id_marca=marcas.codigo
        and equipos.id_tipo=tiposequipos.id
        and equipos.codigo=:equip";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':equip'=>$param]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetch(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    
    
    public function DetallesEquipo($codigo) {
        $consulta = "select 
        equipos.codigo,
        tiposequipos.nombre ||' '|| marcas.nombre||' '|| equipos.modelo as descripcion,
        equipos.serie
        from tiposequipos,equipos,marcas
        where equipos.id_marca=marcas.codigo
        and tiposequipos.id=equipos.id_tipo
        and equipos.codigo=:codigo";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':codigo' => $codigo]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetch(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }
    
    public function Patrones() {
        $consulta = "select 
        equipos.codigo,
        tiposequipos.nombre ||' '|| marcas.nombre||' '|| equipos.modelo as descripcion,
        equipos.serie
        from tiposequipos,equipos,marcas
        where equipos.id_marca=marcas.codigo
        and tiposequipos.id=equipos.id_tipo
        and tiposequipos.categoria='patron'";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->query($consulta);
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

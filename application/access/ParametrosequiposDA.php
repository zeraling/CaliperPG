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
 * Description of ParametrosequiposDA
 *
 * @author Usuario
 */
class ParametrosequiposDA {

    //put your code here

    public function ParametrosEquipos($equipo) {
        $consulta = "select 
            parametros.id,
            parametros.nombre,
            parametrosequipos.id as asign
            from parametros 
            left join parametrosequipos
            on parametrosequipos.id_parametro=parametros.id 
            and parametrosequipos.id_tipoequipo=:equipo";

        $dataBase = new CaliperDB();
        try {
            $query = $dataBase->prepare($consulta);
            $query->execute([':equipo'=>$equipo]);
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $exc) {
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function ParametrosEquipo($param, $array = false) {

        if ($array) {
            $consulta = "select array(
            select parametrosequipos.id_parametro 
            from parametrosequipos 
            where parametrosequipos.id_tipoequipo=" . $param . "
            ) as arrayParams";
        } else {
            $consulta = "select 
            parametrosequipos.id_parametro,
            parametros.nombre as parametro
            from parametrosequipos,parametros
            where parametros.id=parametrosequipos.id_parametro
            and parametrosequipos.id_tipoequipo=" . $param;
        }

        $dataBase = new CaliperDB();
        try {
            $query = $dataBase->prepare($consulta);
            $query->execute();
            $result = $array ? $query->fetch(PDO::FETCH_OBJ) : $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $exc) {
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function ParametroEnEquipo($param) {

        $consulta = "select parametrosequipos.id 
        from parametrosequipos 
        where parametrosequipos.id_parametro=:parame";

        $dataBase = new CaliperDB();
        try {
            $query = $dataBase->prepare($consulta);
            $query->execute([':parame' => $param]);

            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $exc) {
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function AgregarParametro($tipo, $param) {
        $consulta = "INSERT INTO parametrosequipos(id_tipoequipo,id_parametro)VALUES(:tipo,:parametro)";
        $dataBase = new CaliperDB();
        try {
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':tipo', $tipo);
            $query->bindValue(':parametro', $param);
            $result = $query->execute();
            return $result;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return false;
        }
    }

    public function RetirarParametro($tipo, $param) {
        $consulta = "DELETE FROM parametrosequipos WHERE id_tipoequipo=:tipo AND id_parametro=:parametro";
        $dataBase = new CaliperDB();
        try {
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':tipo', $tipo);
            $query->bindValue(':parametro', $param);
            $result = $query->execute();
            return $result;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return false;
        }
    }

}

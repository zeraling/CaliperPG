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
use Application\Connections\CaliperMongo;
use MongoDB\Driver\Exception\Exception as MongoDBException;
use Application\AppLog;

/**
 * Description of MarcasDA
 *
 * @author Usuario
 */
class InformesDA {

    public function Consulta($param) {
        $consulta = "SELECT 
        informes.id_informe,
        informes.numero,
        empresas.nombre as empresa,
        clientes.nombre as cliente,
        tiposequipos.nombre ||' '|| marcas.nombre ||' '|| equipos.modelo as equipo,
        equipos.serie,
        informes.fecha_creacion
        from clientes,equipos,marcas,tiposequipos,informes
            left join empresas on empresas.codigo=informes.id_empresa
        where informes.id_cliente=clientes.codigo
        and informes.id_equipo=equipos.codigo
        and equipos.id_tipo=tiposequipos.id 
        and equipos.id_marca=marcas.codigo 
        ".$param;
        $dataBase = new CaliperDB();

        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->execute();
            //establecer el tipo de retorno de los datos
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }
    
    
    public function VerificarInforme($numero, $empresa) {
        $consulta = "select informes.numero from informes where informes.id_empresa=:empresa and informes.numero=:infor";
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->execute([':empresa' => $numero, ':infor' => $empresa]);

            //establecer el tipo de retorno de los datos
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function InsertarDocumentoInforme(\Application\Data\InformesVO $informe) {
        // Connecting database host
        try {
            // se instancia el cliente controlador y se selecciona base de datos
            $database = (new CaliperMongo())->caliper;
            // selecciona la coleccion (tabla en sql)
            $collection = $database->informes;

            $equipoData = new EquiposDA();
            $infoEquipo = $equipoData->Info($informe->getId_equipo());

            $clientesData = new ClientesDA();
            $infoCliente = $clientesData->DetalleCliente($informe->getId_cliente());

            $empresasData = new EmpresasDA();
            $infoEmpresa = $empresasData->InfoEmpresa($informe->getId_empresa());

            $empleadosData = new EmpleadosDA();
            $infoEmpleado = $empleadosData->DetallesEmpleado($informe->getId_usuario());

            $colleccion = [
                'numero' => $informe->getNumero(),
                'cliente' => $infoCliente,
                'empresa' => $infoEmpresa,
                'equipo' => $infoEquipo,
                'usuario' => [
                    'cedula' => $infoEmpleado[0]->cedula,
                    'nombre' => $infoEmpleado[0]->nombres .' '.$infoEmpleado[0]->apellidos,
                    'cargo' => $infoEmpleado[0]->cargo
                ],
                'calibracion' => [
                    'fecha' => null,
                    'recepcion' => null,
                    'lugar' => '',
                    'ingeniero' => null,
                    'humedad' => ['inicial' => 0, 'final' => 0],
                    'temperatura' => ['inicial' => 0, 'final' => 0]
                ],
                'observaciones' => ''
            ];
            // inserta documento a la coleccion (insert row en sql)
            $resultado = $collection->insertOne($colleccion);
            return $resultado->getInsertedId();
        } catch (MongoDBException $e) {
            AppLog::logDebug($e->getMessage(), $e->getFile(), $e->getLine());
            return false;
        }
    }

    public function RegistrarInforme(\Application\Data\InformesVO $informe) {

        $consulta = "insert into informes(id_informe,fecha_creacion,id_usuario,id_equipo,id_cliente,numero,id_empresa)"
                . "values(:informe,current_timestamp,:usuario,:equipo,:cliente,:numero,:empresa)";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':informe', $informe->getId_informe());
            $query->bindValue(':usuario', $informe->getId_usuario());
            $query->bindValue(':equipo', $informe->getId_equipo());
            $query->bindValue(':cliente', $informe->getId_cliente());
            $query->bindValue(':numero', $informe->getNumero());
            $query->bindValue(':empresa', $informe->getId_empresa());
            // ejecutar la consulta
            $eject = $query->execute();
            return $eject;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return false;
        }
    }

    public function EliminarDocumentoInforme($id_informe) {
        // Connecting database host
        try {
            // se instancia el cliente controlador y se selecciona base de datos
            $database = (new CaliperMongo())->caliper;
            // selecciona la coleccion (tabla en sql)
            $collection = $database->informes;
            //ejecuta eliminacion
            $deleteResult = $collection->deleteOne(['_id' => $id_informe]);
            //retorna resultado
            return $deleteResult;
        } catch (MongoDBException $e) {

            var_dump($e);
            AppLog::logDebug($e->getMessage(), $e->getFile(), $e->getLine());
            return false;
        }
    }

    public function ActualizarInforme($informe, $codiciones) {
        // Connecting database host
        try {
            // se instancia el cliente controlador y se selecciona base de datos
            $database = (new CaliperMongo())->caliper;
            // selecciona la coleccion (tabla en sql)
            $collection = $database->informes;
            //ejecuta consulta 
            $selectResult = $collection->updateOne(
                    ['_id' => new \MongoDB\BSON\ObjectId($informe)], ['$set' => $codiciones]
            );
            
            return $selectResult->getMatchedCount();
        } catch (MongoDBException $e) {
            AppLog::logDebug($e->getMessage(), $e->getFile(), $e->getLine());
            return null;
        }
    }

    public function ObtenerUnInforme($informe) {
        // Connecting database host
        $bson = null;
        try {
            // se instancia el cliente controlador y se selecciona base de datos
            $database = (new CaliperMongo())->caliper;
            // selecciona la coleccion (tabla en sql)
            $collection = $database->informes;
            //ejecuta consulta 
            $selectResult = $collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($informe)]);
            if ($selectResult != null) {
                //el resultado de la consulta viene en formato BSON por lo que hay que convertirlo para usarlo en PHP
                $bson = \MongoDB\BSON\toPHP(\MongoDB\BSON\fromPHP($selectResult));
            }
            return $bson;
        } catch (MongoDBException $e) {
            AppLog::logDebug($e->getMessage(), $e->getFile(), $e->getLine());
            return null;
        }
    }

    public function UnInforme($id) {

        $consulta = 'select * from informes where informes.id_informe=:param';
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':param' => $id]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }
    
    public function EliminaInfo($informe) {

        $consulta = 'delete from informes where informes.id_informe=:param';
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $eject=$query->execute([':param' => $informe]);
            return $eject;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return false;
        }
    }

}

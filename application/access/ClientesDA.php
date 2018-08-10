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
 * Description of ClientesDA
 *
 * @author Usuario
 */
class ClientesDA {

    public function Lista() {
        $consulta = "SELECT
        clientes.codigo,
        clientes.nit,
        clientes.nombre,
        ciudades.nombre as ciudad
        FROM ciudades,clientes 
        WHERE clientes.id_ciudad=ciudades.codigo";
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

    public function ConsultarNit($nit) {
        $consulta = "SELECT
        clientes.codigo
        FROM clientes 
        WHERE clientes.nit=:nit";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->execute([':nit' => $nit]);
            //establecer el tipo de retorno de los datos
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Guardar(\Application\Data\ClientesVO $cliente) {
        $consulta = "INSERT INTO clientes (nit,nombre,direccion,telefono,id_ciudad)"
                . "VALUES(:nit,:nombre,:direccion,:telefono,:ciudad)";

        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':nit', $cliente->getNit(), PDO::PARAM_STR);
            $query->bindValue(':nombre', $cliente->getNombre(), PDO::PARAM_STR);
            $query->bindValue(':direccion', $cliente->getDireccion(), PDO::PARAM_STR);
            $query->bindValue(':telefono', $cliente->getTelefono(), PDO::PARAM_STR);
            $query->bindValue(':ciudad', $cliente->getId_ciudad(), PDO::PARAM_INT);

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

    public function Actualizar(\Application\Data\ClientesVO $cliente) {
        $consulta = "UPDATE clientes SET "
                . "nombre=:nombre,"
                . "telefono=:telefono,"
                . "direccion=:direccion "
                . "WHERE clientes.codigo=:codigo";

        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);

            $query->bindValue(':codigo', $cliente->getCodigo());
            $query->bindValue(':nombre', $cliente->getNombre(), PDO::PARAM_STR);
            $query->bindValue(':direccion', $cliente->getDireccion(), PDO::PARAM_STR);
            $query->bindValue(':telefono', $cliente->getTelefono(), PDO::PARAM_STR);
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

    public function UnCliente($cliente) {
        $consulta = "SELECT 
            clientes.*, 
            ciudades.cod_departamento
            FROM clientes,ciudades
            WHERE clientes.id_ciudad=ciudades.codigo
            AND clientes.codigo=:cliente";
        
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute(['cliente' => $cliente]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }
    
     public function DetalleCliente($codigo) {
        $consulta = "SELECT 
        clientes.codigo,
        clientes.nit,
        clientes.nombre,
        clientes.direccion,
        clientes.telefono,
        departamentos.nombre as departamento,
        ciudades.nombre as ciudad
        FROM clientes,ciudades,departamentos
        WHERE clientes.id_ciudad=ciudades.codigo
        AND ciudades.cod_departamento=departamentos.codigo
        AND clientes.codigo=:cliente";

        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute(['cliente' => $codigo]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetch(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

}

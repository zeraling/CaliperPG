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
 * Description of EmpleadosDA
 *
 * @author Usuario
 */
class EmpleadosDA {

    public function EmpleadoSesion($user) {
        $consulta = "SELECT 
            empleados.cedula,
            empleados.clave_acceso
            FROM empleados,estadosempleados
            WHERE estadosempleados.codigo=empleados.id_estado
            AND empleados.id_estado=1
            AND empleados.cedula=:user";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':user' => $user]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function DetallesEmpleado($usuario) {
        $consulta = "SELECT 
            empleados.cedula,
            empleados.nombres,
            empleados.apellidos,
            empleados.correo,
            empleados.id_cargo,
            cargos.nombre as cargo,
            estadosempleados.nombre as estado,
            empleados.estado_clave,
            empleados.fecha_creacion
            FROM empleados,estadosempleados,cargos
            WHERE cargos.codigo=empleados.id_cargo
            and estadosempleados.codigo=empleados.id_estado
            and empleados.cedula=:user";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':user' => $usuario]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Psw($output1, $cedula) {
        $consulta = "UPDATE empleados SET clave_acceso=:clave,estado_clave=true WHERE empleados.cedula=:cedula";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $eject = $query->execute([':clave' => $output1, ':cedula' => $cedula]);
            // devolvemos el estado del resultado de la consulta
            return $eject;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return false;
        }
    }

    public function Lista() {
        $consulta = "SELECT 
        empleados.cedula,
        empleados.nombres,
        empleados.apellidos,
        cargos.nombre as cargo,
        estadosempleados.nombre as estado
        FROM empleados,estadosempleados,cargos
        WHERE cargos.codigo=empleados.id_cargo
        and estadosempleados.codigo=empleados.id_estado";

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

    public function Actualizar(\Application\Data\EmpleadosVO $empleado) {
        $consulta = "UPDATE empleados SET "
                . "nombres=:nombres,"
                . "apellidos=:apellidos,"
                . "correo=:correo,"
                . "id_cargo=:cargo "
                . "WHERE empleados.cedula=:cedula";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':cedula', $empleado->getCedula());
            $query->bindValue(':nombres', $empleado->getNombres(), PDO::PARAM_STR);
            $query->bindValue(':apellidos', $empleado->getApellidos(), PDO::PARAM_STR);
            $query->bindValue(':correo', $empleado->getCorreo(), PDO::PARAM_STR);
            $query->bindValue(':cargo', $empleado->getId_cargo(), PDO::PARAM_INT);
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

    public function Guardar(\Application\Data\EmpleadosVO $empleado) {
        $consulta = "INSERT INTO empleados(cedula,nombres,apellidos,id_cargo,id_estado,correo,clave_acceso,fecha_creacion,estado_clave)"
                . "VALUES(:cedula,:nombres,:apellidos,:cargo,1,:correo,:clave,current_timestamp,:estadoclave)";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            $query->bindValue(':cedula', $empleado->getCedula(), PDO::PARAM_INT);
            $query->bindValue(':nombres', $empleado->getNombres(), PDO::PARAM_STR);
            $query->bindValue(':apellidos', $empleado->getApellidos(), PDO::PARAM_STR);
            $query->bindValue(':cargo', $empleado->getId_cargo(), PDO::PARAM_INT);
            $query->bindValue(':correo', $empleado->getCorreo(), PDO::PARAM_STR);
            $query->bindValue(':clave', '$2y$10$hYWi9Bu7afP5Npd4tP2meuVhskSQ7ahUfzv43Mz6pVGqRy/xXaE5O', PDO::PARAM_STR);
            $query->bindValue(':estadoclave', false, PDO::PARAM_BOOL);
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

    public function UnEmpleado($user) {
        $consulta = "SELECT * FROM empleados WHERE empleados.cedula=:cedula";
        //instancia y conexion a base de datos
        $dataBase = new CaliperDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([':cedula' => $user]);
            // procesamos el resultado de la consulta
            $resultados = $query->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function ListaActivos() {
        $consulta = "SELECT 
            empleados.cedula,
            empleados.nombres,
            empleados.apellidos,
            cargos.nombre as cargo,
            estadosempleados.nombre as estado
            FROM empleados,estadosempleados,cargos
            WHERE cargos.codigo=empleados.id_cargo
            and empleados.id_estado=1
            and estadosempleados.codigo=empleados.id_estado";

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
    
     public function PersonalCalibracion($condicion) {
        $consulta="SELECT 
        empleados.cedula,
        empleados.nombres ||' '|| empleados.apellidos as usuario
        FROM empleados
        WHERE empleados.id_estado=1 
        ".$condicion;
        
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

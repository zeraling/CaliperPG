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
        $consulta = "SELECT 
        PRODUCTOS.Codigo,
        TIPOSPRODUCTOS.CodCategoria,
        CATEGORIASPRODUCTOS.Nombre as Categoria,
        PRODUCTOS.IdTipo,
        TIPOSPRODUCTOS.Nombre as TipoProducto,
        PRODUCTOS.CodMarca,
        MARCAS.Nombre as MarcaProducto,
        PRODUCTOS.Modelo,
        CASE 
            WHEN TIPOSPRODUCTOS.CodCategoria = 1 OR TIPOSPRODUCTOS.CodCategoria =2
                THEN TIPOSPRODUCTOS.Nombre+' '+MARCAS.Nombre +' '+PRODUCTOS.Modelo
            WHEN TIPOSPRODUCTOS.CodCategoria = 3
                THEN TIPOSPRODUCTOS.Nombre +' '+PRODUCTOS.Modelo
            ELSE TIPOSPRODUCTOS.Nombre
        END AS NombreProducto,
        PRODUCTOS.Detalles
        FROM CATEGORIASPRODUCTOS,PRODUCTOS,TIPOSPRODUCTOS,MARCAS
        WHERE PRODUCTOS.IdTipo=TIPOSPRODUCTOS.Id
        AND MARCAS.Codigo=PRODUCTOS.CodMarca
        AND CATEGORIASPRODUCTOS.Codigo=TIPOSPRODUCTOS.CodCategoria
        " . $param;
        //instancia y conexion a base de datos
        $dataBase = new GnesisDB();
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

    public function ProductoEspecifico(\Application\Data\ProductosVO $param) {
        $consulta = "SELECT 
        PRODUCTOS.Codigo
        FROM PRODUCTOS
        WHERE PRODUCTOS.CodMarca=:marca
        AND PRODUCTOS.IdTipo=:tipo
        AND PRODUCTOS.Modelo=:modelo";

        //instancia y conexion a base de datos
        $dataBase = new GnesisDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);
            // ejecutar la consulta
            $query->execute([
                ':marca' => $param->getIdTipo(),
                ':modelo' => $param->getModelo(),
                ':tipo' => $param->getCodMarca()
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

    public function Registrar(\Application\Data\ProductosVO $producto) {
        $consulta = "INSERT INTO PRODUCTOS(IdTipo,CodMarca,Modelo,Detalles,UrlCatalogo)"
                . "VALUES(:tipo,:marca,:modelo,:descripcion,:catalogo)";
        //instancia y conexion a base de datos
        $dataBase = new GnesisDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);

            $query->bindValue(':tipo', $producto->getIdTipo(), PDO::PARAM_INT);
            $query->bindValue(':marca', $producto->getCodMarca(), PDO::PARAM_INT);
            $query->bindValue(':modelo', $producto->getModelo(), PDO::PARAM_STR);
            $query->bindValue(':descripcion', $producto->getDetalles(), PDO::PARAM_STR);
            $query->bindValue(':catalogo', $producto->getUrlCatalogo(), PDO::PARAM_STR);

            // ejecutar la consulta
            $query->execute();
            // devolvemos el ultimo identificador insertado
            $identidad = $dataBase->lastInsertId('PRODUCTOS');
            return $identidad;
        } catch (PDOException $exc) {
            // si ocurre algun error se genera la excepcion y se crea un log 
            AppLog::logDebug($exc->getMessage(), $exc->getFile(), $exc->getLine());
            return null;
        }
    }

    public function Actualizar(\Application\Data\ProductosVO $producto) {
        $consulta = "UPDATE PRODUCTOS SET "
                . "Detalles=:descripcion "
                . "WHERE PRODUCTOS.Codigo=:codigo";
        //instancia y conexion a base de datos
        $dataBase = new GnesisDB();
        try {
            // preparar el DML a ejecutar
            $query = $dataBase->prepare($consulta);

            $query->bindValue(':codigo', $producto->getCodigo(), PDO::PARAM_INT);
            $query->bindValue(':descripcion', $producto->getDetalles(), PDO::PARAM_STR);
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

    public function UnProducto($codigo) {
        $consulta = "SELECT DatosProductos.* FROM DatosProductos WHERE DatosProductos.Codigo=:codigo";
        //instancia y conexion a base de datos
        $dataBase = new GnesisDB();
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

    public function ProductosParaCotizar($codigo) {
        $consulta = "SELECT 
        DatosProductos.Codigo,
        DatosProductos.CodCategoria,
        DatosProductos.TipoProducto,
        DatosProductos.NombreProducto
        FROM DatosProductos
        WHERE DatosProductos.IdTipo=" . $codigo . " 
        AND ( 
            SELECT COUNT(PRO.Codigo) as Precios
            FROM PRECIOSPRODUCTOS as PRO
            WHERE PRO.CodProducto=DatosProductos.Codigo 
        ) > 0";

        //instancia y conexion a base de datos
        $dataBase = new GnesisDB();
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

}

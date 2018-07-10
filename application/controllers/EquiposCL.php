<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\CustomFunctions;
use Application\Access\ProductosDA;

/**
 * Description of ProductosCL
 *
 * @author Usuario
 */
class EquiposCL extends CustomFunctions {

    private $serviceData;

    function __construct() {
        $ProductosService = new ProductosDA();
        $this->serviceData = $ProductosService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ConsultaProductos($data) {
        $condiciones = " ";
        try {
            $condiciones .= $data->categoria > 0 ? " AND TIPOSPRODUCTOS.CodCategoria=" . $data->categoria : "";
            $condiciones .= $data->marca > 0 ? " AND PRODUCTOS.CodMarca=" . $data->marca : "";
            $condiciones .= $data->producto > 0 ? " AND PRODUCTOS.IdTipo=" . $data->producto : "";
            $condiciones .= $data->codigo > 0 ? " AND PRODUCTOS.Codigo=" . $data->codigo : "";

            $Consulta = $this->serviceData->Consulta($condiciones);
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function VerificarUnProducto(\Application\Data\ProductosVO $param) {
        try {
            $accion = $this->serviceData->ProductoEspecifico($param);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function RegistrarProducto(\Application\Data\ProductosVO $equipo) {
        try {
            $Guardar = $this->serviceData->Registrar($equipo);
            return $Guardar;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ActualizarProducto(\Application\Data\ProductosVO $equipo) {
        try {
            $Guardar = $this->serviceData->Actualizar($equipo);
            return $Guardar;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaUnProducto($producto) {
        try {
            $equipo1 = $this->serviceData->UnProducto($producto);
            return $equipo1;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaProductosParaCotizar($codigo) {
        try {
            $lista = $this->serviceData->ProductosParaCotizar($codigo);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
}

<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of FuncionesempleadosVO
 *
 * @author Usuario
 */
class FuncionesempleadosVO {

    private $id;
    private $cod_funcion;
    private $id_empleado;
    private $fecha_asignacion;

    function getId() {
        return $this->id;
    }

    function getCod_funcion() {
        return $this->cod_funcion;
    }

    function getId_empleado() {
        return $this->id_empleado;
    }

    function getFecha_asignacion() {
        return $this->fecha_asignacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCod_funcion($cod_funcion) {
        $this->cod_funcion = $cod_funcion;
    }

    function setId_empleado($id_empleado) {
        $this->id_empleado = $id_empleado;
    }

    function setFecha_asignacion($fecha_asignacion) {
        $this->fecha_asignacion = $fecha_asignacion;
    }

}

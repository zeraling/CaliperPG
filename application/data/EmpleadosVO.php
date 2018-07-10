<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of EmpleadosVO
 *
 * @author Usuario
 */
class EmpleadosVO {

    private $cedula;
    private $nombres;
    private $apellidos;
    private $id_cargo;
    private $id_estado;
    private $correo;
    private $clave_acceso;
    private $fecha_creacion;
    private $estado_clave;

    function getCedula() {
        return $this->cedula;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getId_cargo() {
        return $this->id_cargo;
    }

    function getId_estado() {
        return $this->id_estado;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getClave_acceso() {
        return $this->clave_acceso;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getEstado_clave() {
        return $this->estado_clave;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setId_cargo($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    function setId_estado($id_estado) {
        $this->id_estado = $id_estado;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setClave_acceso($clave_acceso) {
        $this->clave_acceso = $clave_acceso;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setEstado_clave($estado_clave) {
        $this->estado_clave = $estado_clave;
    }

}

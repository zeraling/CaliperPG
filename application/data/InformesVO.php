<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  CaliperPG App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of InformeVO
 *
 * @author Usuario
 */
class InformesVO {

    //put your code here

    private $id_informe;
    private $fecha_creacion;
    private $id_usuario;
    private $id_equipo;
    private $id_cliente;
    private $numero;
    private $id_empresa;

    function getId_informe() {
        return $this->id_informe;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getId_usuario() {
        return $this->id_usuario;
    }

    function getId_equipo() {
        return $this->id_equipo;
    }

    function getId_cliente() {
        return $this->id_cliente;
    }

    function getNumero() {
        return $this->numero;
    }

    function getId_empresa() {
        return $this->id_empresa;
    }

    function setId_informe($id_informe) {
        $this->id_informe = $id_informe;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function setId_equipo($id_equipo) {
        $this->id_equipo = $id_equipo;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

}

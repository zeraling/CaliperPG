<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of CalibracionpatronesVO
 *
 * @author Usuario
 */
class CalibracionpatronesVO {

    //put your code here
    private $codigo;
    private $cod_patron;
    private $fecha_actual;
    private $fecha_proxima;
    private $estado;
    private $aplica;

    function getCodigo() {
        return $this->codigo;
    }

    function getCod_patron() {
        return $this->cod_patron;
    }

    function getFecha_actual() {
        return $this->fecha_actual;
    }

    function getFecha_proxima() {
        return $this->fecha_proxima;
    }

    function getEstado() {
        return $this->estado;
    }

    function getAplica() {
        return $this->aplica;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCod_patron($cod_patron) {
        $this->cod_patron = $cod_patron;
    }

    function setFecha_actual($fecha_actual) {
        $this->fecha_actual = $fecha_actual;
    }

    function setFecha_proxima($fecha_proxima) {
        $this->fecha_proxima = $fecha_proxima;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setAplica($aplica) {
        $this->aplica = $aplica;
    }

}

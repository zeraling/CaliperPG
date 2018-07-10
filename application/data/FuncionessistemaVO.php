<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of FuncionessistemaVO
 *
 * @author Usuario
 */
class FuncionessistemaVO {

    private $codigo;
    private $nombre;
    private $cod_modulo;
    private $descripcion;

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCod_modulo() {
        return $this->cod_modulo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCod_modulo($cod_modulo) {
        $this->cod_modulo = $cod_modulo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

}

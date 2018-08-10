<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of ProductosVO
 *
 * @author Usuario
 */
class EquiposVO {

    //put your code here   
    private $codigo;
    private $id_tipo;
    private $id_marca;
    private $modelo;
    private $serie;

    function getCodigo() {
        return $this->codigo;
    }

    function getId_tipo() {
        return $this->id_tipo;
    }

    function getId_marca() {
        return $this->id_marca;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getSerie() {
        return $this->serie;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setId_tipo($id_tipo) {
        $this->id_tipo = $id_tipo;
    }

    function setId_marca($id_marca) {
        $this->id_marca = $id_marca;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }
}
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
    private $Codigo;
    private $IdTipo;
    private $CodMarca;
    private $Modelo;
    private $Detalles;
    private $UrlCatalogo;

    function getCodigo() {
        return $this->Codigo;
    }

    function getIdTipo() {
        return $this->IdTipo;
    }

    function getCodMarca() {
        return $this->CodMarca;
    }

    function getModelo() {
        return $this->Modelo;
    }

    function getDetalles() {
        return $this->Detalles;
    }

    function getUrlCatalogo() {
        return $this->UrlCatalogo;
    }

    function setCodigo($Codigo) {
        $this->Codigo = $Codigo;
    }

    function setIdTipo($IdTipo) {
        $this->IdTipo = $IdTipo;
    }

    function setCodMarca($CodMarca) {
        $this->CodMarca = $CodMarca;
    }

    function setModelo($Modelo) {
        $this->Modelo = $Modelo;
    }

    function setDetalles($Detalles) {
        $this->Detalles = $Detalles;
    }

    function setUrlCatalogo($UrlCatalogo) {
        $this->UrlCatalogo = $UrlCatalogo;
    }

}

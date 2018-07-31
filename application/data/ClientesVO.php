<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of ClientesVO
 *
 * @author Usuario
 */
class ClientesVO {

    //put your code here

    private $codigo;
    private $nit;
    private $nombre;
    private $direccion;
    private $telefono;
    private $id_ciudad;

    function getCodigo() {
        return $this->codigo;
    }

    function getNit() {
        return $this->nit;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getId_ciudad() {
        return $this->id_ciudad;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setId_ciudad($id_ciudad) {
        $this->id_ciudad = $id_ciudad;
    }

}

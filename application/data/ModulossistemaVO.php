<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of ModulossistemaVO
 *
 * @author Usuario
 */
class ModulossistemaVO {

    //put your code here 
    private $codigo;
    private $nombre;

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
}

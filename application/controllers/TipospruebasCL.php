<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\TipospruebasDA;

/**
 * Description of CargosCL
 *
 * @author Usuario
 */
class TipospruebasCL {

    private $serviceData;

    function __construct() {
        $pruebasService = new TipospruebasDA();
        $this->serviceData = $pruebasService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ListaTipos() {
        try {
            $accion = $this->serviceData->Lista();
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

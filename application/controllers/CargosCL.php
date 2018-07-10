<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\CargosDA;

/**
 * Description of CargosCL
 *
 * @author Usuario
 */
class CargosCL {

    private $serviceData;

    function __construct() {
        $CargosService = new CargosDA();
        $this->serviceData = $CargosService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ListaCargos() {
        try {
            $accion = $this->serviceData->Lista();
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

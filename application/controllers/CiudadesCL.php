<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\CiudadesDA;

/**
 * Description of CiudadesCL
 *
 * @author Usuario
 */
class CiudadesCL {

    private $serviceData;

    //put your code here

    function __construct() {
        $CiudadesService = new CiudadesDA();
        $this->serviceData = $CiudadesService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function CargarCiudad($departamento) {
        try {
            $ListaCiudades=  $this->serviceData->ListaPorDepartamento($departamento);
            return $ListaCiudades;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    public function ListaCiudades() {
        try {
            $ListaCiudades=  $this->serviceData->Lista();
            return $ListaCiudades;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

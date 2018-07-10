<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of CargosCL
 *
 * @author Usuario
 */
class EmpresasCL {

    private $serviceData;

    function __construct() {
        $EmpresasService = new \Application\Access\EmpresasDA();
        $this->serviceData = $EmpresasService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ListaEmpresas() {
        try {
            $accion = $this->serviceData->Lista();
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

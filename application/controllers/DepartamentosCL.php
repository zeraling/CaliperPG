<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\DepartamentosDA;

/**
 * Description of DepartamentosCL
 *
 * @author Usuario
 */
class DepartamentosCL {

    private $serviceData;
    //put your code here
    
    public function __construct() {
        $DepartamentosService = new DepartamentosDA();
        $this->serviceData=$DepartamentosService;
    }
    
    public function __destruct() {
        $this->serviceData;
    }
    
    public function ListaDepartamentos() {
        try {
            $accion=  $this->serviceData->Lista();
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    

}

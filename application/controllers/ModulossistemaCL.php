<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\ModulossistemaDA;
use Application\Data\ModulossistemaVO;

/**
 * Description of ModulossistemaCL
 *
 * @author Usuario
 */
class ModulossistemaCL {

    private $serviceData;

    function __construct() {
        $ModulossistemaService = new ModulossistemaDA();
        $this->serviceData = $ModulossistemaService;
    }

    function __destruct() {
        $this->serviceData;
    }
    
    public function ListaModulos() {
        try {
            $acion = $this->serviceData->Lista();
            return $acion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ListaFuncionesModulos() {
        $modulos= $this->serviceData->Lista();
        if (!empty($modulos)) {
            foreach ($modulos as $lista) {
                $lista->funciones = $this->serviceData->PermisosModulo($lista->codigo);
            }
        }
        return $modulos;
    }

}

<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\MarcasDA;

/**
 * Description of MarcasCL
 *
 * @author Usuario
 */
class MarcasCL {

    private $serviceData;

    function __construct() {
        $MarcasService = new MarcasDA();
        $this->serviceData = $MarcasService;
    }

    function __destruct() {
        $this->serviceData;
    }
    
     public function ListaMarcas() {
        try {
            $lista = $this->serviceData->Lista();
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaUnaMarca($id) {
        try {
            $lista = $this->serviceData->UnaMarca($id);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function VerificarMarca($marca) {
        try {
            $lista = $this->serviceData->Verificar($marca);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function AgregarMarca(\Application\Data\MarcasVO $marca) {
        try {
            $lista = $this->serviceData->Agregar($marca);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ActualizarMarca(\Application\Data\MarcasVO $marca) {
        try {
            $lista = $this->serviceData->Actualizar($marca);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}

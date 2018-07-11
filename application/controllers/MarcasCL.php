<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;


/**
 * Description of MarcasCL
 *
 * @author Usuario
 */
class MarcasCL {

    private $serviceData;

    function __construct() {
        $MarcasService = new \Application\Access\MarcasDA();
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

    public function AgregarMarca($marca) {
        try {
            $lista = $this->serviceData->Agregar($marca);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ActualizarMarca($code,$marca) {
        try {
            $lista = $this->serviceData->Actualizar($code,$marca);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}

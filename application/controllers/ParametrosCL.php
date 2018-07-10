<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of ParametrosCL
 *
 * @author Usuario
 */
class ParametrosCL {
    //put your code here
    
    private $serviceData;
    
    public function __construct() {
        $parametrosService= new \Application\Access\ParametrosDA();
        return $this->serviceData=$parametrosService;
    }

    public function __destruct() {
        
    }
    
    public function ListaParametros() {
        try {
            $lista=  $this->serviceData->Lista();
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function VerificarParametro($parametro) {
        try {
            $lista = $this->serviceData->Verificar($parametro);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function AgregarParametro($parametro) {
        try {
            $lista = $this->serviceData->Agregar($parametro);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ActualizarParametro($code,$parametro) {
        try {
            $lista = $this->serviceData->Actualizar($code,$parametro);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaUnParametro($code) {
        try {
            $lista = $this->serviceData->UnParametro($code);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}

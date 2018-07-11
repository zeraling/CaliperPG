<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of UnidadesparametrosCL
 *
 * @author Usuario
 */
class UnidadesparametrosCL {
    //put your code here
    
    private $serviceData;
    
    public function __construct() {
        $unidadesService= new \Application\Access\UnidadesparametrosDA();
        return $this->serviceData=$unidadesService;
    }

    public function __destruct() {
         $this->serviceData;
    }
    
    public function ListaUnidades() {
        try {
            $lista=  $this->serviceData->Lista();
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function VerificarUnidad($unidad) {
        try {
            $lista = $this->serviceData->Verificar($unidad);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function AgregarUnidad($unidad) {
        try {
            $lista = $this->serviceData->Agregar($unidad);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ActualizarUnidad($code,$unidad) {
        try {
            $lista = $this->serviceData->Actualizar($code,$unidad);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaUnaUnidad($code) {
        try {
            $lista = $this->serviceData->UnaUnidad($code);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}

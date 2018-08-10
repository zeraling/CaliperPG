<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\TiposequiposDA;

/**
 * Description of TiposequiposCL
 *
 * @author Usuario
 */
class TiposequiposCL {

     private $serviceData;

    function __construct() {
        $TiposequiposService = new TiposequiposDA();
        $this->serviceData = $TiposequiposService;
    }

    function __destruct() {
        $this->serviceData;
    }
    
    public function ListaGeneral() {
        try {
            $lista=  $this->serviceData->ConsultaGeneral();
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ConsultaEquiposTipo($tipo) {
        try {
            $lista=  $this->serviceData->EquiposPorTipo($tipo);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ListaTiposEquipos() {
        try {
            $lista=  $this->serviceData->ConsultaEquipos();
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
     public function VerificarTipo($nombre) {
        try {
            $lista=$this->serviceData->Verificar($nombre);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
     
    public function AgregarTipo($nombre,$tipo) {
        try {
            $lista=$this->serviceData->Agregar($nombre,$tipo);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
     public function ActualizarTipo($id,$nombre) {
        try {
            $lista = $this->serviceData->Actualizar($id,$nombre);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ConsultaUnTipo($id) {
        try {
            $lista = $this->serviceData->UnTipo($id);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
   
    
}

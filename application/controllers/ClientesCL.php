<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of ClientesCL
 *
 * @author Usuario
 */
class ClientesCL {
    //put your code here
    
    private $serviceData;

    function __construct() {
        $ClientesService = new \Application\Access\ClientesDA();
        $this->serviceData = $ClientesService;
    }

    function __destruct() {
        $this->serviceData;
    }
    
    public function ListaClientesEmpresas($empresas) {
        try {
            $lista=  $this->serviceData->ClientesEmpresas($empresas);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function ConsultarNitCliente($nit,$empresa) {
        try {
            $lista=  $this->serviceData->ConsultarNit($nit,$empresa);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

     public function ActualziarCliente(\Application\Data\ClientesVO $cliente){
        try{
            $Guardar=$this->serviceData->Actualizar($cliente);
            return $Guardar;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
      public function GuardarCliente(\Application\Data\ClientesVO $cliente){
        try{
            $Guardar=  $this->serviceData->Guardar($cliente);
            return $Guardar;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
      public function ConsultaUnCliente($Cliente){
        try {
            $cliente1=$this->serviceData->UnCliente($Cliente);
            return $cliente1;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
    
}

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

    public function ListaClientes() {
        try {
            $lista = $this->serviceData->Lista();
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultarNitCliente($nit) {
        try {
            $lista = $this->serviceData->ConsultarNit($nit);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ActualziarCliente(\Application\Data\ClientesVO $cliente) {
        try {
            $Guardar = $this->serviceData->Actualizar($cliente);
            return $Guardar;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function GuardarCliente(\Application\Data\ClientesVO $cliente) {
        try {
            $Guardar = $this->serviceData->Guardar($cliente);
            return $Guardar;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultaUnCliente($Cliente) {
        try {
            $cliente1 = $this->serviceData->UnCliente($Cliente);
            return $cliente1;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function InfoCliente($codigo) {
        try {
            $lista=$this->serviceData->DetalleCliente($codigo);
            return $lista;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
}

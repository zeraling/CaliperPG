<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

use Application\Access\FuncionessistemaDA;
use Application\Data\FuncionessistemaVO;

/**
 * Description of FuncionessistemaCL
 *
 * @author Usuario
 */
class FuncionessistemaCL {

    //put your code here
    private function serviceData() {
        $FuncionessistemaService = new FuncionessistemaDA();
        return $FuncionessistemaService;
    }
    
    public function ListaFunciones() {
        try {
            $Consulta = $this->serviceData()->Lista();
            return $Consulta;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
     public function ConsultaUnaFuncion($id){
        try{
             $Consulta=$this->serviceData()->UnaFuncion($id);
            return $Consulta;
        }  catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

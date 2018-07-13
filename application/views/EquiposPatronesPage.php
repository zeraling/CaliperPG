<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Views;

use Application\RenderPages;
use Application\Controllers\EquipospatronesCL;
/**
 * Description of Equipospage
 *
 * @author Usuario
 */
class EquiposPatronesPage extends RenderPages{
    //put your code here
    
    public function getIndex() {
        $equiposPatrones =new EquipospatronesCL();
        $data['listPatrones']=$equiposPatrones->ListadoPatrones();
        
        return $this->render('patrones/listado.twig',$data);
    }
       
    public function getForm($code = null) {
        $marcasEquipos=new \Application\Controllers\MarcasCL();
        $data['listaMarcas']=$marcasEquipos->ListaMarcas();

        if ($code != null && $code > 0) {
            $customController = new \Application\Controllers\EquipospatronesCL();
            $info = $customController->ConsultaUnEquipo($code);
            if(!empty($info)){
                $data['patron'] = $info[0];
            }
        }
        return $this->render('patrones/form.twig', $data);
    }
    
    
}

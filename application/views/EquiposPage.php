<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Views;

use Application\RenderPages;
use Application\Controllers\EquiposCL;
/**
 * Description of Equipospage
 *
 * @author Usuario
 */
class EquiposPage extends RenderPages{
    //put your code here
    
    public function getIndex() {
        $tiposEquipos=new \Application\Controllers\TiposequiposCL();
        $data['listTipos']=$tiposEquipos->ListaTiposEquipos();
        
        $marcasEquipos=new \Application\Controllers\MarcasCL();
        $data['listMarcas']=$marcasEquipos->ListaMarcas();
        
        return $this->render('equipos/lista.twig',$data);
    }
    
    public function getMarcas() {
        $unidadesContrl = new \Application\Controllers\MarcasCL();
        $data['listMarcas'] = $unidadesContrl->ListaMarcas();

        return $this->render('equipos/marcas.twig', $data);
    }
    
    public function getForm($code = null) {
        $tiposEquipos=new \Application\Controllers\TiposequiposCL();
        $data['listaTipos']=$tiposEquipos->ListaTiposEquipos();

        $marcasEquipos=new \Application\Controllers\MarcasCL();
        $data['listaMarcas']=$marcasEquipos->ListaMarcas();

        if ($code != null && $code > 0) {
            $customController = new EquiposCL();
            $info = $customController->ConsultaUnEquipo($code);
            if(!empty($info)){
                $data['equipo'] = $info[0];
            }
        }
        return $this->render('equipos/form.twig', $data);
    }
    
    
}

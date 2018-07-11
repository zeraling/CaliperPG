<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Views;

use \Application\RenderPages;

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
    
    
}

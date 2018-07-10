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
        $ListaEquipos=$tiposEquipos->ListaTiposEquipos();
        
        
        
        
        return $this->render('equipos/lista.twig',$data);
    }
    
    
    
    
}

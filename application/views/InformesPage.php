<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Views;

use Application\RenderPages;
use Application\Controllers\InformesCL;
/**
 * Description of InformesPage
 *
 * @author Usuario
 */
class InformesPage extends RenderPages{
    //put your code here
    public function getIndex() {
        $empresasControl = new \Application\Controllers\EmpresasCL();
        $data['listEmpresas'] = $empresasControl->ListaEmpresas();
        
        $customController = new \Application\Controllers\ClientesCL();
        $data['listClientes'] = $customController->ListaClientes();
        
        $tiposEquipos=new \Application\Controllers\TiposequiposCL();
        $data['listTipos']=$tiposEquipos->ListaTiposEquipos();
        
        return $this->render('informes/listado.twig',$data);
    }
    
    public function getForm($code = null) {
        $empresasControl = new \Application\Controllers\EmpresasCL();
        $data['listEmpresas'] = $empresasControl->ListaEmpresas();
        
        if($code!=null && $code>0){
            $informesCon= new InformesCL();
            
        }
        
        return $this->render('informes/form.twig',$data);
    }
    
}

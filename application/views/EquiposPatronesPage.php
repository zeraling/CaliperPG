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
    
    public function getCalibracion($code) {
        if ($code != null && $code > 0) {
            $customController = new \Application\Controllers\EquipospatronesCL();
            $info = $customController->ConsultaUnEquipo($code);
            if(!empty($info)){
                $data['patron'] = $info[0];
                
                $calibraControl = new \Application\Controllers\CalibracionpatronesCL();
                $data['listCalibracion'] = $calibraControl->ConsultaCalibracionesPatron($info[0]->codigo);
      
                $data['mensaje'] = 'no data';
                $pageRender= $this->render('patrones/calibracion.twig', $data);
                
            }else{
                $data['mensaje'] = 'no data';
                $pageRender= $this->render('patrones/null.twig', $data);
            }
        }else{
            $data['mensaje'] = 'no carga';
            $pageRender= $this->render('patrones/null.twig', $data);
        }
        return $pageRender;
    }
    
    
    public function getParams($code) {
        if ($code != null && $code > 0) {
            $customController = new \Application\Controllers\EquipospatronesCL();
            $info = $customController->ConsultaUnEquipo($code);
            if(!empty($info)){
                $data['patron'] = $info[0];
                
                $paramControl = new \Application\Controllers\ParametrosCL();
                $data['listParametros'] = $paramControl->ListaParametros();
                
                $unidadControl = new \Application\Controllers\UnidadesparametrosCL();
                $data['listUnidad'] = $unidadControl->ListaUnidades();
                
                $pruebasControl = new \Application\Controllers\TipospruebasCL();
                $data['listPruebas'] = $pruebasControl->ListaTipos();
                
                $paramAsignadosControl = new \Application\Controllers\ParametrospatronesCL();
                $data['listParametros'] = $paramAsignadosControl->ConsultaParametrosPatron($info[0]->codigo);
      
                $data['mensaje'] = 'no data';
                $pageRender= $this->render('patrones/params.twig', $data);
                
            }else{
                $data['mensaje'] = 'no data';
                $pageRender= $this->render('patrones/null.twig', $data);
            }
        }else{
            $data['mensaje'] = 'no carga';
            $pageRender= $this->render('patrones/null.twig', $data);
        }
        return $pageRender;
    }
}

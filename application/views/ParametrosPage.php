<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Views;

use Application\RenderPages;

/**
 * Description of ParametrosPage
 *
 * @author Usuario
 */
class ParametrosPage extends RenderPages {

    //put your code here
    public function getIndex() {
        $tiposContrl = new \Application\Controllers\TiposequiposCL();
        $data['listTipos'] = $tiposContrl->ListaTiposEquipos();

        return $this->render('parametros/equipos.twig', $data);
    }

    public function getLista() {
        $parametrosContrl = new \Application\Controllers\ParametrosCL();
        $data['listParametros'] = $parametrosContrl->ListaParametros();

        return $this->render('parametros/lista.twig', $data);
    }

    public function getAdmin($code = null) {
        if ($code != null && $code > 0) {
            $tiposControl = new \Application\Controllers\TiposequiposCL();
            $tipoEq = $tiposControl->ConsultaUnTipo($code);
            $data['tipoEq'] = $tipoEq[0];

            $paramControl = new \Application\Controllers\ParametrosequiposCL();
            $data['listParametros'] = $paramControl->ConsultaParametrosEquipos($code);
            
        } else {
            $parametrosContrl = new \Application\Controllers\ParametrosCL();
            $data['listParametros'] = $parametrosContrl->ListaParametros();
        }
        return $this->render('parametros/admin.twig', $data);
    }

    public function getUnidades() {
        $unidadesContrl = new \Application\Controllers\UnidadesparametrosCL();
        $data['listUnidades'] = $unidadesContrl->ListaUnidades();

        return $this->render('parametros/unidades.twig', $data);
    }
    
}

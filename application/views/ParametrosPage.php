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

        return $this->render('parametros/lista.twig', $data);
    }

    public function getAdmin() {
        $parametrosContrl = new \Application\Controllers\ParametrosCL();
        $data['listParametros'] = $parametrosContrl->ListaParametros();

        return $this->render('parametros/admin.twig', $data);
    }

    public function getEquipos($code = null) {
        if ($code != null && $code > 0) {
            $tiposControl = new \Application\Controllers\TiposequiposCL();
            $tipoEq = $tiposControl->ConsultaUnTipo($code);
            $data['tipoEq'] = $tipoEq[0];

            $paramControl = new \Application\Controllers\ParametrosequiposCL();
            $data['listParametros'] = $paramControl->ConsultaParametrosEquipo($code);
            
        } else {
            $parametrosContrl = new \Application\Controllers\ParametrosCL();
            $data['listParametros'] = $parametrosContrl->ListaParametros();
        }
        return $this->render('parametros/form.twig', $data);
    }

}

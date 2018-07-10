<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */
namespace Application\Views;

use Application\RenderPages;

/**
 * Description of IndexView
 *
 * @author Usuario
 */
class DashBoardPage extends RenderPages {
    //put your code here
    public function getIndex() {
        return $this->render('dashboard/index.twig');
    }
    
    public function getUsuario() {
        global $dataUser;
        $empleadoControl = new \Application\Controllers\EmpleadosCL();
        $infoEmpleado = $empleadoControl->ConsultaDetallesEmpleado($dataUser[0]->cedula);
        $datos['user'] = $infoEmpleado[0];
        return $this->render('dashboard/perfil.twig',$datos);
    }

}

<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Views;

use Application\RenderPages;
use Application\Controllers\EmpleadosCL;

/**
 * Description of EmpleadosPage
 *
 * @author Usuario
 */
class EmpleadosPage extends RenderPages {

    //put your code here
    public function getIndex() {
        $empresasControl = new \Application\Controllers\EmpresasCL();
        $data['selectEmpresa'] = $empresasControl->ListaEmpresas();

        $estadosControl = new \Application\Controllers\EstadosempleadosCL();
        $data['selectEstado'] = $estadosControl->ListaEstado();

        $cargosControl = new \Application\Controllers\CargosCL();
        $data['selectCargo'] = $cargosControl->ListaCargos();

        return $this->render('sistema/index.twig', $data);
    }

    public function getForm($id = null) {
        $cargosControl = new \Application\Controllers\CargosCL();
        $data['selectCargo'] = $cargosControl->ListaCargos();

        if ($id != null && $id > 0) {
            $customController = new EmpleadosCL();
            $info = $customController->ConsultaUnEmpleado($id);
            $data['empleado'] = $info[0];

            $empresaEmpl = new \Application\Controllers\EmpresasempleadosCL();
            $data['selectEmpresa'] = $empresaEmpl->ConsultaEmpresasAsignadas($info[0]->cedula);  
        }else{
            $empresasControl = new \Application\Controllers\EmpresasCL();
            $data['selectEmpresa'] = $empresasControl->ListaEmpresas();
        }
        return $this->render('sistema/form.twig', $data);
    }

    public function getPermisos() {
        $empleadosControl = new EmpleadosCL();
        $data['empleados'] = $empleadosControl->ListaEmpleadosActivos();

        $modulosControl = new \Application\Controllers\ModulossistemaCL();
        $data['permisos'] = $modulosControl->ListaFuncionesModulos();

        return $this->render('sistema/permisos.twig', $data);
    }

}

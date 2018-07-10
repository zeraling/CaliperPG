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
 * Description of ClientesPage
 *
 * @author Usuario
 */
class ClientesPage extends RenderPages {

    //put your code here

    public function getIndex() {
        global $dataUser;
        $empresaEmpl = new \Application\Controllers\EmpresasempleadosCL();
        $empAsign = $empresaEmpl->ConsultaAsignaciones($dataUser[0]->cedula);

        $customController = new \Application\Controllers\ClientesCL();
        $data['listaClientes'] = $customController->ListaClientesEmpresas($empAsign->asignadas);
        return $this->render('clientes/lista.twig', $data);
    }
    
    public function getForm($code = null) {

        $empresasControl = new \Application\Controllers\EmpresasCL();
        $data['selectEmpresa'] = $empresasControl->ListaEmpresas();

        $ciudades = new \Application\Controllers\CiudadesCL();
        $departamentos = new \Application\Controllers\DepartamentosCL();
        $data['listaDepartamentos'] = $departamentos->ListaDepartamentos();

        if ($code != null && $code > 0) {
            $customController = new \Application\Controllers\ClientesCL();
            $cliente = $customController->ConsultaUnCliente($code);
            if (!empty($cliente)) {
                $data['cliente'] = $cliente[0];
                $data['nitCliente'] = explode('-', $cliente[0]->nit);
                $data['listaCiudad'] = $ciudades->CargarCiudad($cliente[0]->cod_departamento);
            }
        }
        return $this->render('clientes/form.twig', $data);
    }

}

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
class InformesPage extends RenderPages {

    //put your code here
    public function getIndex() {
        global $dataAcces;

        $empresasControl = new \Application\Controllers\EmpresasCL();
        $data['listEmpresas'] = $empresasControl->ListaEmpresas();

        $customController = new \Application\Controllers\ClientesCL();
        $data['listClientes'] = $customController->ListaClientes();

        $tiposEquipos = new \Application\Controllers\TiposequiposCL();
        $data['listTipos'] = $tiposEquipos->ListaTiposEquipos();

        return $this->render('informes/listado.twig', $data);
    }

    public function getForm() {
        $empresasControl = new \Application\Controllers\EmpresasCL();
        $data['listEmpresas'] = $empresasControl->ListaEmpresas();

        $clientesController = new \Application\Controllers\ClientesCL();
        $data['listaClientes'] = $clientesController->ListaClientes();

        $tiposEquipos = new \Application\Controllers\TiposequiposCL();
        $data['listTipos'] = $tiposEquipos->ListaTiposEquipos();

        return $this->render('informes/form.twig', $data);
    }

    public function getDetalles($param) {
        global $dataUser;
        global $dataAcces;

        if ($param != null && $param != '') {
            $informesControl = new InformesCL();
            $informe = $informesControl->ConsultarDetalleInforme($param);
            
            
            $empleadosControl = new \Application\Controllers\EmpleadosCL();
            if ($dataAcces[0]->estado == 1) {
                $data['empleadosFirma'] = $empleadosControl->ConsultaPersonalCalibracion($dataUser[0]->cedula);
            } else {
                $data['empleadosFirma'] = $empleadosControl->ConsultaPersonalCalibracion();
            }

            if ($informe) {
                $data['informe'] = $informe;
                $pageRender = $this->render('informes/detalles.twig', $data);
            } else {
                $data['mensaje'] = 'informe no cargado';
                $pageRender = $this->render('informes/null.twig', $data);
            }
        } else {
            $data['mensaje'] = 'id informe no valido';
            $pageRender = $this->render('informes/null.twig', $data);
        }
        return $pageRender;
    }
    
    public function getPruebas($param) {
        if ($param != null && $param != '') {
            $informesControl = new InformesCL();
            $informe = $informesControl->ConsultarDetalleInforme($param);
            if ($informe) {
                $data['informe'] = $informe;
                $pageRender = $this->render('informes/pruebas.twig', $data);
            } else {
                $data['mensaje'] = 'informe no cargado';
                $pageRender = $this->render('informes/null.twig', $data);
            }
        } else {
            $data['mensaje'] = 'id informe no valido';
            $pageRender = $this->render('informes/null.twig', $data);
        }
        return $pageRender;
    }
    
    

}

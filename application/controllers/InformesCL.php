<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Controllers;

/**
 * Description of Informes
 *
 * @author Usuario
 */
class InformesCL {

    //put your code here

    private $serviceData;

    function __construct() {
        $TiposequiposService = new \Application\Access\InformesDA();
        $this->serviceData = $TiposequiposService;
    }

    function __destruct() {
        $this->serviceData;
    }

    public function ConsultaInformes($data) {
        try {
            $condiciones = "";
            $condiciones .= $data->empresa > 0 ? " AND informes.id_empresa=" . $data->empresa : "";
            $condiciones .= $data->cliente > 0 ? " AND informes.id_cliente=" . $data->cliente : "";
            $condiciones .= $data->equipo > 0 ? " AND equipos.id_tipo=" . $data->equipo . "" : "";
            $condiciones .= $data->codigo > 0 ? " AND informes.numero=" . $data->codigo : "";

            $eject = $this->serviceData->Consulta($condiciones);
            return $eject;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function verificarNumeroInforme($numero, $empresa) {
        try {
            $accion = $this->serviceData->VerificarInforme($numero, $empresa);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function RegistrarInforme(\Application\Data\InformesVO $informe) {
        try {
            $idInforme = $this->serviceData->InsertarDocumentoInforme($informe);
            if ($idInforme) {
                $informe->setId_informe($idInforme);
                $registro = $this->serviceData->RegistrarInforme($informe);
                if ($registro == false) {
                    $this->serviceData->EliminarDocumentoInforme($idInforme);
                    return false;
                } else {
                    return (string) $idInforme;
                }
            } else {
                $this->serviceData->EliminarDocumentoInforme($idInforme);
                return false;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ConsultarDetalleInforme($param) {
        try {
            $accion = $this->serviceData->ObtenerUnInforme($param);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
     public function ActualizarDetallesInforme($informe,$condiciones) {
        try {
            $accion = $this->serviceData->ActualizarInforme($informe,$condiciones);
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
     public function EliminarInforme($idInfo) {
        try {
            $accion = $this->serviceData->EliminaInfo($idInfo);
            if($accion){
                $this->serviceData->EliminarDocumentoInforme(new \MongoDB\BSON\ObjectId($idInfo));
            }
            return $accion;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

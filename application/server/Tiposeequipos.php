<?php

/*
 * Copyright (C) 2018 Sistemas 
 * Gnesis App - CR EQUIPOS SA
 * Archivo Creado por Zeraling
 */
include_once '../../vendor/autoload.php';

use Application\Controllers\TiposequiposCL;
use Application\Controllers\ParametrosequiposCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => ''));
} else {
    switch ($accion) {
        case 'Guardar':
            $tiposControl = new TiposequiposCL();
            $disponible = $tiposControl->VerificarTipo($Nombre);
            if (!empty($disponible)) {
                echo json_encode(array('respuesta' => false, 'code' => 'creado'));
            } else {
                $idReg = $tiposControl->AgregarTipo($Nombre);
                if ($idReg > 0) {
                    $parametrosControl = new ParametrosequiposCL();
                    $regs = $parametrosControl->AgregarParametrosEquipo($idReg, $parametros);
                    echo json_encode(array('respuesta' => true, 'code' => $idReg, 'params' => $regs));
                } else {
                    echo json_encode(array('respuesta' => false, 'code' => '', 'params' => 0));
                }
            }
            break;
        case 'Actualizar':
            $tiposControl = new TiposequiposCL();
            
            $info= $tiposControl->ConsultaUnTipo($Codigo);
            if($Nombre!=$info[0]->nombre){
                $consulta = $tiposControl->VerificarTipo($Nombre);
                $disponible=!empty($consulta)?false:true;
            }else{
                $disponible=true;
            }
            if (!$disponible) {
                echo json_encode(array('respuesta' => false, 'code' => 'creado'));
            } else {
                $actualiza= $tiposControl->ActualizarTipo($Codigo,$Nombre);
                if ($actualiza) {
                    $parametrosControl = new ParametrosequiposCL();
                    $regs = $parametrosControl->ActualziarParametrosEquipo($Codigo, $parametros);
                    echo json_encode(array('respuesta' => true, 'code' => $Codigo, 'params' => $regs));
                } else {
                    echo json_encode(array('respuesta' => false, 'code' => '', 'params' => 0));
                }
            }
            break;
        default:
            echo json_encode(array("status" => false, "code" => "noAction"));
            break;
    }
}
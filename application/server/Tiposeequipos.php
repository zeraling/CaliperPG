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
                $idReg = $tiposControl->AgregarTipo($Nombre,$Categoria);
                if ($idReg > 0) {
                    if(isset($parametros)){
                        $parametrosControl = new ParametrosequiposCL();
                        $regs = $parametrosControl->AgregarParametrosEquipo($idReg, $parametros);
                    }else{
                        $regs=0;
                    }
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
                    
                    $paramActuales=$parametrosControl->ConsultaParametrosEquipo($Codigo);
                    if(!empty($paramActuales)&&!isset($parametros)){
                        $regs = $parametrosControl->RetirarParametrosEquipo($Codigo);
                    }elseif(!empty($paramActuales)&&isset($parametros)){
                        $regs = $parametrosControl->ActualziarParametrosEquipo($Codigo, $parametros);
                    }elseif(empty($paramActuales)&&isset($parametros)){
                        $regs = $parametrosControl->AgregarParametrosEquipo($Codigo, $parametros);
                    }else{
                        $regs=0;
                    }
                     echo json_encode(array('respuesta' => true, 'code' => $Codigo, 'params' => $regs)); 
                } else {
                    echo json_encode(array('respuesta' => false, 'code' => '', 'params' => 0));
                }
            }
        break;
        case 'cargarProductosTipo':
            $tiposControl = new TiposequiposCL();
            $eject = $tiposControl->ConsultaEquiposTipo($tipo);

            $modelosDetalles = Array();
            if (!empty($eject)) {
                echo json_encode($eject);
            }else{
                echo json_encode(array());
            }
        break; 
        default:
            echo json_encode(array("status" => false, "code" => "noAction"));
            break;
    }
}
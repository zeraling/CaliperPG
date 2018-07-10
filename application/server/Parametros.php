<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\ParametrosCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'Guardar':
            $parametrosControl=new ParametrosCL();
            
            $disponible=$parametrosControl->VerificarParametro($Nombre);
            if(!empty($disponible)){
                echo json_encode(array('respuesta'=>false,'code'=>'creada'));
            }else{
                $accion=$parametrosControl->AgregarParametro($Nombre);
                echo json_encode(array('respuesta'=>$accion,'code'=>''));
            }
            
        break;
        case 'Actualizar':
            $parametrosControl=new ParametrosCL();
            
            $disponible=$parametrosControl->VerificarParametro($Nombre);
            if(!empty($disponible)){
                echo json_encode(array('respuesta'=>false,'code'=>'creada'));
            }else{
                $accion=$parametrosControl->ActualizarParametro($Codigo,$Nombre);
                echo json_encode(array('respuesta'=>$accion,'code'=>''));
            }
        break;
        case 'dataParam':
            $parametrosControl=new ParametrosCL();
            $info=$parametrosControl->ConsultaUnParametro($id);
            echo json_encode($info[0]);
        break;
        default:
            echo "Accion no Programada";
            break;
    }
}
<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\UnidadesparametrosCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'Guardar':
            $unidadControl=new UnidadesparametrosCL();
            
            $disponible=$unidadControl->VerificarUnidad($Nombre);
            if(!empty($disponible)){
                echo json_encode(array('respuesta'=>false,'code'=>'creada'));
            }else{
                $accion=$unidadControl->AgregarUnidad($Nombre);
                echo json_encode(array('respuesta'=>$accion,'code'=>''));
            }
            
        break;
        case 'Actualizar':
            $unidadControl=new UnidadesparametrosCL();
            
            $disponible=$unidadControl->VerificarUnidad($Nombre);
            if(!empty($disponible)){
                echo json_encode(array('respuesta'=>false,'code'=>'creada'));
            }else{
                $accion=$unidadControl->ActualizarUnidad($Codigo,$Nombre);
                echo json_encode(array('respuesta'=>$accion,'code'=>''));
            }
        break;
        case 'dataParam':
            $unidadControl=new UnidadesparametrosCL();
            $info=$unidadControl->ConsultaUnaUnidad($id);
            echo json_encode($info[0]);
        break;
        default:
            echo "Accion no Programada";
            break;
    }
}
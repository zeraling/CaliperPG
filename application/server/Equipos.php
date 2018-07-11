<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\MarcasCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'Guardar':
            $marcasControl=new MarcasCL();
            
            $disponible=$marcasControl->VerificarMarca($Nombre);
            if(!empty($disponible)){
                echo json_encode(array('respuesta'=>false,'code'=>'creada'));
            }else{
                $accion=$marcasControl->AgregarMarca($Nombre);
                echo json_encode(array('respuesta'=>$accion,'code'=>''));
            }
            
        break;
        case 'Actualizar':
            $marcasControl=new MarcasCL();
            
            $disponible=$unidadControl->VerificarUnidad($Nombre);
            if(!empty($disponible)){
                echo json_encode(array('respuesta'=>false,'code'=>'creada'));
            }else{
                $accion=$unidadControl->ActualizarUnidad($Codigo,$Nombre);
                echo json_encode(array('respuesta'=>$accion,'code'=>''));
            }
        break;
        case 'dataParam':
            $marcasControl=new MarcasCL();
            $info=$unidadControl->ConsultaUnaUnidad($id);
            echo json_encode($info[0]);
        break;
        default:
            echo "Accion no Programada";
            break;
    }
}
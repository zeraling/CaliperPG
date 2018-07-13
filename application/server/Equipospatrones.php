<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\EquipospatronesCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'Guardar':
            $equiposControl = new EquipospatronesCL();
            $miEquipo = new \Application\Data\EquipospatronesVO();

            $miEquipo->setNombre($Nombre);
            $miEquipo->setId_marca($CodMarca);
            $miEquipo->setModelo($Modelo);
            $miEquipo->setSerie($noSerie);
            
            $disponible = $equiposControl->VerificarUnEquipo($noSerie);
            if (!empty($disponible)) {
                echo json_encode(array('respuesta' => false, 'code' => 'creado'));
            } else {
                $accion = $equiposControl->RegistrarEquipo($miEquipo);
                echo json_encode(array('respuesta' =>($accion>0?true:false), 'code' =>$accion));
            }
            break;
        case 'Actualizar':
            echo json_encode(array('respuesta' =>true, 'code' => 'no hace nada'));
        break;
        case 'dataParam':
            $equiposControl = new EquiposCL();
            $info = $equiposControl->ConsultaUnEquipo($id);
            echo json_encode($info[0]);
            break;
        default:
            echo "Accion no Programada";
            break;
    }
}
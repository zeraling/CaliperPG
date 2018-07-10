<?php

/*
 * Copyright (C) 2018 Sistemas 
 * Gnesis App - CR EQUIPOS SA
 * Archivo Creado por Zeraling
 */
include_once '../../vendor/autoload.php';

use Application\Controllers\FuncionesempleadosCL;

extract($_POST);
if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => ''));
} else {
    switch ($accion) {
        case 'listaFuncionesUser':
            $modulosControl = new FuncionesempleadosCL();
            $ListaPermisos = $modulosControl->ConsultaPermisosAsignados($user);
            $modulos = array();
            if (!empty($ListaPermisos)) {
                foreach ($ListaPermisos as $val => $h) {
                    $modulos[] = array(
                        'id' => 'funcion-'.$h->codigo,
                        'estado' => $h->estado
                    );
                }
            }
            echo json_encode($modulos);
        break;
        case 'asignarPermiso':
            $empleadoControl = new FuncionesempleadosCL();;
            $ejec = $empleadoControl->AsignarPermisos($funcion, $empleado);
            echo json_encode(array('respuesta' => $ejec));
        break;
        case 'quitarPermiso':
            $modulosControl = new FuncionesempleadosCL();
            $ejke = $modulosControl->BorrarPermisos($funcion, $empleado);
            echo json_encode(array('respuesta' => $ejke));
        break;
        default:
            echo json_encode(array('status' => false, 'code' => 'noAction'));
            break;
    }
}
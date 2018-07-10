<?php

/*
 * Copyright (C) 2018 Sistemas 
 * Gnesis App - CR EQUIPOS SA
 * Archivo Creado por Zeraling
 */
include_once '../../vendor/autoload.php';

use Application\Controllers\EstadosempleadosCL;

extract($_POST);
if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => ''));
} else {
    switch ($accion) {
        case 'Consultar';
            $dataConsulta = json_decode($data);

            $empleadosControl = new EstadosempleadosCL();
            $ListaEmpleados = $empleadosControl->ConsultaEmpleados($dataConsulta);
            if (!empty($ListaEmpleados)) {
                foreach ($ListaEmpleados as $value) {
                    $opciones = 'code="'. $value->cedula . '" estado="' . $value->id_estado . '"';
                    $datos[] = array(
                        'opciones' =>'<span '.$opciones.' >' . $value->cedula . '</span>',
                        'cedula' => $value->cedula,
                        'nombre' => ($value->nombres),
                        'apellido' => ($value->apellidos),
                        'estado' => $value->estado
                    );
                }
            }
            echo json_encode($datos);
        break;
        case 'restablecer':
            $empleadoControl = new EstadosempleadosCL();
            $restablece = $empleadoControl->RestablecerPws($cedulaRed);
            echo json_encode(array('respuesta' => $restablece));
            break;
        case 'cambiarestado':
            $empleadoControl = new EstadosempleadosCL();
            $restablece = $empleadoControl->CambiarEstado($id, $estado);
            echo json_encode(array('respuesta' => $restablece));
            break;
        default:
            echo json_encode(array('status' => false, 'code' => 'noAction'));
            break;
    }
}
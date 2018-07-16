<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\CalibracionpatronesCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'GuardarFecha':
            $calibracionControl = new CalibracionpatronesCL();
            $miCalibracion = new Application\Data\CalibracionpatronesVO();

            $fechaNull = $calibracionControl->ConsultaFechasNull($codPatron);

            if (!empty($fechaNull)) {
                echo json_encode(array('respuesta' => false, 'code' => 'fechaNull'));
            } else {
                $miCalibracion->setCod_patron($codPatron);
                if ($aplica == 1) {
                    $miCalibracion->setFecha_actual($fechaActual);
                    $miCalibracion->setFecha_proxima($fechaProxima);
                } else {
                    $miCalibracion->setFecha_actual(null);
                    $miCalibracion->setFecha_proxima(null);
                }

                $miCalibracion->setEstado(1);
                $miCalibracion->setAplica($aplica);
                
                $fechaReg = $calibracionControl->RegistrarFecha($miCalibracion);
                if ($fechaReg > 0) {
                    $calibracionControl->InactivarFechasPatron($codPatron, $fechaReg);
                    echo json_encode(array('respuesta' => true, 'code' => $fechaReg));
                } else {
                    echo json_encode(array('respuesta' => false, 'code' => 'err'));
                }
            }
            break;
        case 'GuardarFechaNula':
            $calibracionControl = new CalibracionpatronesCL();
            $miCalibracion = new Application\Data\CalibracionpatronesVO();

            $fechasCarga = $calibracionControl->ConsultaCalibracionesPatron($codPatron);

            if (!empty($fechasCarga)) {
                echo json_encode(array('respuesta' => false, 'code' => 'fechaCarga'));
            } else {
                $miCalibracion->setCod_patron($codPatron);
                $miCalibracion->setFecha_actual(null);
                $miCalibracion->setFecha_proxima(null);

                $miCalibracion->setEstado(1);
                $miCalibracion->setAplica($aplica);

                $fechaReg = $calibracionControl->RegistrarFecha($miCalibracion);
                if ($fechaReg > 0) {
                    $calibracionControl->InactivarFechasPatron($codPatron, $fechaReg);
                    echo json_encode(array('respuesta' => true, 'code' => $fechaReg));
                } else {
                    echo json_encode(array('respuesta' => false, 'code' => 'err'));
                }
            }
        break;
        default:
            echo "Accion no Programada";
            break;
    }
}
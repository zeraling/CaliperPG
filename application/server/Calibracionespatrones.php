<?php
/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\EquiposCL;
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
        case 'info':
            $equipoControl = new EquiposCL();
            $dataPatron = $equipoControl->ConsultaDetallesEquipo($codePatron);
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <td colspan="3"><?php echo $dataPatron->descripcion ?></td>
                    </tr>
                    <tr>
                        <th>Actual Calibracion</th>
                        <th>Proxima Calibracion</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $calibracionesCn = new CalibracionpatronesCL();
                        $lista = $calibracionesCn->ConsultaCalibracionesPatron($codePatron);
                        if (!empty($lista)) {
                            foreach ($lista as $value) {
                                echo '<tr>';
                                echo '<td>' . ($value->aplica == true ? date('d/m/Y', strtotime($value->fecha_actual)) : 'no Aplica') . '</td>';
                                echo '<td>' . ($value->aplica == true ? date('d/m/Y', strtotime($value->fecha_proxima)) : 'no Aplica') . '</td>';
                                echo '<td>' . ($value->estado == true ? 'Activa' : 'Inactiva') . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<td colspan="3">No Hay Fechas</td>';
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
            <?php
            break;
        default:
            echo "Accion no Programada";
            break;
    }
}
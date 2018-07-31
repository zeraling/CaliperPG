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
use Application\Controllers\CalibracionpatronesCL;

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
                echo json_encode(array('respuesta' => ($accion > 0 ? true : false), 'code' => $accion));
            }
            break;
        case 'Actualizar':
            echo json_encode(array('respuesta' => true, 'code' => 'no hace nada'));
            break;
        case 'dataParam':
            $equiposControl = new EquipospatronesCL();
            $info = $equiposControl->ConsultaUnEquipo($id);
            echo json_encode($info[0]);
            break;
        case 'info':
            $equipoControl = new EquipospatronesCL();
            $dataPatron = $equipoControl->ConsultaDetallesPatron($codePatron);
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
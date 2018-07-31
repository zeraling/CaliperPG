<?php
/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\ParametrospatronesCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
       case 'cargarParametroPatron':
            $parametrosControl = new ParametrospatronesCL();
            $lista = $parametrosControl->ConsultaParametrosPatron($codPatron);
            $datos = Array();
            if (!empty($lista)) {
                foreach ($lista as $values) {
                    $opciones = '<button type="button" class="btn btn-minier btn-danger btnDeleteParam" data="' . $values->id . '"><i class="fa fa-minus"></i></button>';

                    $datos[] = array(
                        'id' => $values->id,
                        'parametro' => $values->parametro,
                        'unidad' => $values->unidad,
                        'res' => $values->resolucion,
                        'up' => $values->incertidumbre,
                        'tolera' => $values->valor_tolerancia . ' ' .$values->unidad_tolerancia,
                        'opcion'=>$opciones
                    );
                }
            }
            echo json_encode($datos);
        break;
        case 'asignarParametro':
            $parametrosControl = new ParametrospatronesCL();
            $miParametro = new \Application\Data\ParametrospatronesVO();

            $miParametro->setCod_patron($codPatron);
            $miParametro->setCod_prueba($CodPrueba);
            $miParametro->setId_parametro($IdParametro);
            $miParametro->setId_unidad($IdUnidad);
            $miParametro->setIncertidumbre($Up);
            $miParametro->setResolucion($Resolucion);
            $miParametro->setValor_tolerancia($Tolerancia);
            $miParametro->setUnidad_tolerancia($unidTol);

            $reg=$parametrosControl->AsignarParametroPatron($miParametro);
            echo json_encode(array('respuesta'=>$reg));
        break;
       case 'eliminarParam':
           $parametrosControl = new ParametrospatronesCL();
           $ejct=$parametrosControl->EliminarParametroAsignado($code);
           echo json_encode(array('respuesta'=>$ejct));
        break;
        case 'parametrosEquipo':
            $parametrosControl = new ParametrospatronesCL();
            $lista = $parametrosControl->ConsultaParametrosPatron($codPatron);
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Parametro</th>
                    </tr>    
                </thead>
                <tbody>
                    <?php
                    if (!empty($lista)) {
                        foreach ($lista as $value) {
                            echo '<tr>';
                            echo '<td>' . $value->id_parametro . '</td>';
                            echo '<td>' . $value->parametro . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>  
                </tbody>
            </table>
            <?php
            break;
        default:
            echo "Accion no Programada";
            break;
    }
}
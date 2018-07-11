<?php
/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\ParametrosequiposCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'parametrosEquipo':
            $parametrosControl = new ParametrosequiposCL();
            $lista = $parametrosControl->ConsultaParametrosEquipo($codEquipo);
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
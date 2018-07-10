<?php

/*
 * Copyright (C) 2018 Sistemas 
 * Gnesis App - CR EQUIPOS SA
 * Archivo Creado por Zeraling
 */
include_once '../../vendor/autoload.php';

use Application\Controllers\EmpleadosCL;

extract($_POST);
if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => ''));
} else {
    switch ($accion) {
        case '':

            echo '';
            break;
        default:
            echo json_encode(array('status' => false, 'code' => 'noAction'));
            break;
    }
}
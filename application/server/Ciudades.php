<?php

/*
 * Copyright (C) 2018 Sistemas 
 * Gnesis App - CR EQUIPOS SA
 * Archivo Creado por Zeraling
 */
include_once '../../vendor/autoload.php';

use Application\Controllers\CiudadesCL;

extract($_POST);
if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => ''));
} else {
    switch ($accion) {
        case 'cargarciudad':
            $ciudad = Array();

            $CiudadControl = new CiudadesCL();
            $ListaCiudades = $CiudadControl->CargarCiudad($departamento);
            if (!empty($ListaCiudades)) {
                foreach ($ListaCiudades as $valc => $a) {

                    $ciudad[] = array(
                        "id" => $a->codigo,
                        "nombre" => ($a->nombre)
                    );
                }
            }

            echo json_encode($ciudad);
            break;
        case 'Lista':
            $ciudades = new CiudadCtr();
            $ListaCiudad = $ciudades->ListaCiudad();
            if (!empty($ListaCiudad)) {
                echo "<option value=''></option>";
                foreach ($ListaCiudad as $valc => $h) {
                    echo "<option value='" . $h->Codigo . "'>" . ($h->Nombre) . "</option>";
                }
            } else {
                echo "<option value=''>No se han Cargado Las Ciudades</option>";
            }
        break;
        default:
            echo json_encode(array("status" => false, "code" => "noAction"));
            break;
    }
}
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

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'Consultar';
            $dataConsulta = json_decode($data);
            $datos = Array();
            $equiposControl = new EquiposCL();
            $ListaProductos = $equiposControl->ConsultaEquipos($dataConsulta);
            if (!empty($ListaProductos)) {
                foreach ($ListaProductos as $value) {
                    $datos[] = array(
                        'codigo' => '<span data=' . $value->codigo . '>' . $value->codigo . '</span>',
                        'equipo' => $value->tipo,
                        'marca' => $value->marca,
                        'modelo' => $value->modelo
                    );
                }
            }
            echo json_encode($datos);
            break;
        case 'Guardar':
            $equiposControl = new EquiposCL();
            $miEquipo = new \Application\Data\EquiposVO();

            $miEquipo->setId_marca($CodMarca);
            $miEquipo->setId_tipo($IdTipoEquipo);
            $miEquipo->setModelo($Modelo);
            $miEquipo->setSerie($Serie);

            $disponible = $equiposControl->VerificarUnEquipo($Serie);
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
        
        case 'infoEquipo':
            $equiposControl = new EquiposCL();
            $info = $equiposControl->ConsultaInfoEquipo($code);
            
            echo '<span class="green">Equipo:</span> ' . $info->tipo . '<br>';
            echo '<span class="green">Marca:</span> ' . $info->marca . '<br>';
            echo '<span class="green">Modelo:</span> ' . $info->modelo . '<br>';
            echo '<span class="green">Serie:</span> ' . $info->serie . '<br>';
            
        break;
        default:
            echo "Accion no Programada";
        break;
    }
}
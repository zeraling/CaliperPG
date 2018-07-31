<?php

/* 
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */
include_once '../../vendor/autoload.php';

use Application\Controllers\ClientesCL;

extract($_POST);
if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'Guardar':
            $clientes = new ClientesCL();
            
            $nit=''.$Nit.'-'.$dv;
            $disponible = $clientes->ConsultarNitCliente($nit);
            if (empty($disponible)) {
                $MiCliente = new \Application\Data\ClientesVO();
                $MiCliente->setNit($nit);
                $MiCliente->setNombre($Nombre);
                $MiCliente->setDireccion($Direccion);
                $MiCliente->setTelefono("" . $Telefono . "");
                $MiCliente->setId_ciudad($ciudad);
                
                $ejec = $clientes->GuardarCliente($MiCliente);
                
                if($ejec>0){
                     echo json_encode(array('respuesta' => true, 'code' => $ejec));
                }else{
                     echo json_encode(array('respuesta' => false, 'code' =>'errReg'));
                }
            } else {
                echo json_encode(array('respuesta' => false, 'code' =>'noNit'));
            }
            break;
        case 'Actualiza':
            $clientes = new ClientesCL();
            $MiCliente = new \Application\Data\ClientesVO();

            $MiCliente->setCodigo($Codigo);
            $MiCliente->setNombre($Nombre);
            $MiCliente->setDireccion($Direccion);
            $MiCliente->setTelefono("" . $Telefono . "");

            $ejec = $clientes->ActualziarCliente($MiCliente);
            echo json_encode(array('respuesta' => $ejec, 'code' => $Nit));

            break;
        case 'info':
            $clientes = new ClientesCtrl();

            $info = $clientes->InfoCliente($nit);
            if (!empty($info)) {
                echo '<span class="text-green">NIT</span> ' . $info[0]->Nit . '<br>';
                echo '<span class="text-green">Nombre</span> ' . $info[0]->Nombre . '<br>';
                echo '<span class="text-green">Direccion</span> ' . $info[0]->Direccion . '<br>';
                echo '<span class="text-green">Telefono</span> ' . $info[0]->Telefono . '<br>';
                echo '<span class="text-green">Ciudad</span> ' . $info[0]->Ciudad . '<br>';
            } else {
                echo " No Se Cargaron los Datos del Cliente";
            }

            break;

        case 'Cliente':
            $datos = Array();
            $clientes = new ClientesCtrl();
            $info1 = $clientes->InfoCliente($nitCarga);

            if (!empty($info1)) {

                $datos = array(
                    'respuesta' => true,
                    'nit' => $info1[0]->Nit,
                    'nombre' => utf8_encode($info1[0]->Nombre),
                    'direccion' => utf8_encode($info1[0]->Direccion),
                    'telefono' => $info1[0]->Telefono,
                    'idciudad' => $info1[0]->IdCiudad,
                    'ciudad' => utf8_encode($info1[0]->Ciudad)
                );
            }else{
                $datos = array('respuesta' => false);
            }
            echo json_encode($datos);
            
        break;
        case 'listaClientes':
            $clientes = new ClientesCtrl();
            $lista = $clientes->ListaClientes();
            if (!empty($lista)) {
                echo "<option value=''>- Seleccione Uno -</option>";
                foreach ($lista as $valc => $a) {
                    echo "<option value='" . $a->Nit . "'>" . $a->Nit . "</option>";
                }
            } else {
                echo "<option value=''>No se han Cargado Los Clientes</option>";
            }

            break;
        default:
            echo 'Accion no Programada';
            break;
    }
}
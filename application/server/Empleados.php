<?php
/*
 * Copyright (C) 2018 Sistemas 
 * Gnesis App - CR EQUIPOS SA
 * Archivo Creado por Zeraling
 */
include_once '../../vendor/autoload.php';

use Application\Controllers\EmpleadosCL;
use Application\Controllers\FuncionesempleadosCL;
use Application\Controllers\EmpresasempleadosCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => ''));
} else {
    switch ($accion) {
        case 'inicioSesion':
            $empleados = new EmpleadosCL();
            $detalUser = $empleados->ConsultaEmpleadoSesion($codeUser);

            if (!empty($detalUser)) {
                $PaswdKey = password_verify($empleados->encryptKey($usPasswd, 'dublin'), $detalUser[0]->clave_acceso);
                if ($detalUser[0]->cedula == $codeUser && $PaswdKey == true) {
                    //asigno un nombre a la sesión para poder guardar diferentes datos 
                    session_name("caliperUser");
                    // inicio la sesión
                    session_start();
                    //defino la sesión que demuestra que el usuario está autorizado 
                    $_SESSION['calLogKey'] = md5(uniqid(mt_rand(), true));
                    //defino la fecha y hora de inicio de sesión en formato aaaa-mm-dd 
                    $_SESSION["calLastAcces"] = date("Y-m-d H:i:s");
                    //cargo los datos del usuario que se loguea
                    $_SESSION['calUser'] = base64_encode($detalUser[0]->cedula);

                    $mensaje = array('respuesta' => true, 'code' => 'Inicio');
                } else {
                    $mensaje = array('respuesta' => false, 'code' => 'Error');
                }
            } else {
                $mensaje = array('respuesta' => false, 'code' => 'noData');
            }
            echo json_encode($mensaje);
            break;

        case 'Guardar':

            $empleadoControl = new EmpleadosCL();
            $disponible = $empleadoControl->ConsultaUnEmpleado($Cedula);

            if (!empty($disponible)) {
                echo json_encode(array('respuesta' => false, 'code' => 'noDisponible'));
            } else {
                $Miempleado = new \Application\Data\EmpleadosVO();
                $Miempleado->setCedula($Cedula);
                $Miempleado->setNombres($Nombres);
                $Miempleado->setApellidos($Apellidos);
                $Miempleado->setId_cargo($IdCargo);
                $Miempleado->setCorreo(strtolower($Correo));

                $eje = $empleadoControl->GuardarEmpleado($Miempleado);
                $empresasControl = new EmpresasempleadosCL();
                $regEmpresa = 0;
                foreach ($empresas as $value) {
                    $carga = $empresasControl->RegistrarEmpleado($Cedula, $value);
                    $carga ? $regEmpresa = $regEmpresa + 1 : 0;
                }
                echo json_encode(array('respuesta' => $eje, 'code' => $Cedula, 'empresas' => $regEmpresa));
            }
            break;
        case 'Actualizar':
            $empleadoControl = new EmpleadosCL();
            $Miempleado = new \Application\Data\EmpleadosVO();

            $Miempleado->setCedula($Codigo);
            $Miempleado->setNombres(($Nombres));
            $Miempleado->setApellidos(($Apellidos));
            $Miempleado->setId_cargo($IdCargo);
            $Miempleado->setCorreo(strtolower($Correo));

            $empresasControl = new EmpresasempleadosCL();
            $empresasControl->EliminarAsignacion($Codigo);
            $regEmpresa = 0;
            foreach ($empresas as $value) {
                $carga = $empresasControl->RegistrarEmpleado($Codigo, $value);
                $carga ? $regEmpresa = $regEmpresa + 1 : 0;
            }

            $ejec = $empleadoControl->ActualizarEmpleado($Miempleado);
            echo json_encode(array('respuesta' => $ejec, 'code' => $Codigo, 'empresas' => $regEmpresa));
            break;
        case 'info':

            $empleadoControl = new EmpleadosCL();
            $uSer = $empleadoControl->ConsultaDetallesEmpleado($id);
            ?>
            <table class="table">
                <tr>
                    <td><b>Cedula:</b></td>
                    <td><?php echo $uSer[0]->cedula; ?></td>
                </tr>
                <tr>
                    <td><b>Nombres:</b></td>
                    <td><?php echo ($uSer[0]->nombres); ?></td>
                </tr>
                <tr>
                    <td><b>Apellidos:</b></td>
                    <td><?php echo ($uSer[0]->apellidos); ?></td>
                </tr>
                <tr>
                    <td><b>Correo:</b></td>
                    <td><?php echo $uSer[0]->correo; ?></td>
                </tr>
                <tr>
                    <td><b>Cargo:</b></td>
                    <td><?php echo $uSer[0]->cargo; ?></td>
                </tr>
                <tr>
                    <td><b>Empresa:</b></td>
                    <td>
                        <?php
                        $empresasEm= new EmpresasempleadosCL();
                        $asing=$empresasEm->ConsultaEmpresasAsignadas($uSer[0]->cedula);
                        foreach ($asing as $val){
                            echo $val->asign!=null?$val->nombre.'<br>':'';
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <?php
            $funcionesControl = new FuncionesempleadosCL();
            $ListaPermisos = $funcionesControl->PermisosUsuario($id);

            if (!empty($ListaPermisos)) {
                echo '<table class="table">';
                echo '<tr><th>Item</td><th>Permisos o Funciones</td></tr>';
                foreach ($ListaPermisos as $val) {
                    echo '<tr><td>' . $val->cod_funcion . '</td><td>' . $val->nombre . '</td></tr>';
                }
                echo '</table>';
            }
            break;
        case 'cambiarClave':
            $empleadoControl = new EmpleadosCL();
            $output1 = $empleadoControl->encryptKey($reclave, 'dublin');
            $Key = password_hash($output1, PASSWORD_DEFAULT, [15]);

            $Actualar = $empleadoControl->ActualarPws($Key, base64_decode($cedula));
            echo json_encode(array('respuesta' => $Actualar));
            break;
        default:
            echo json_encode(array("status" => false, "code" => "noAction"));
            break;
    }
}
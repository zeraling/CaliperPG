<?php
/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

require_once '../../vendor/autoload.php';
/* Inport de Clases */

use Application\Controllers\InformesCL;

extract($_POST);

if (empty($accion)) {
    echo json_encode(array('status' => false, 'code' => 'noAction'));
} else {

    switch ($accion) {
        case 'consultarInformes':
            $informesControl = new InformesCL();
            $dataConsulta = json_decode($data);

            $result = $informesControl->ConsultaInformes($dataConsulta);
            $datos = Array();

            if (!empty($result)) {
                foreach ($result as $value) {
                    $datos[] = array(
                        'codigo' => '<span data="' . $value->id_informe . '">' . $value->numero . '</span>',
                        'empresa' => $value->empresa,
                        'cliente' => $value->cliente,
                        'equipo' => $value->equipo . ' ' . $value->serie,
                        'fecha' => date('d/m/Y', strtotime($value->fecha_creacion))
                    );
                }
            }
            echo json_encode($datos);
            break;
        case 'verificarNo':
            $informesControl = new InformesCL();

            $consulta = $informesControl->verificarNumeroInforme($informe, $empresa);
            if (!empty($consulta)) {
                echo json_encode(array('respuesta' => false));
            } else {
                echo json_encode(array('respuesta' => true));
            }

            break;

        case 'guardarInforme':
            $informesControl = new InformesCL();

            $miInforme = new Application\Data\InformesVO();
            $miInforme->setId_usuario(base64_decode($siCode));
            $miInforme->setId_equipo($CodEquipo);
            $miInforme->setId_cliente($IdCliente);
            $miInforme->setNumero($numero);
            $miInforme->setId_empresa($IdEmpresa);

            $disponible = $informesControl->verificarNumeroInforme($numero, $IdEmpresa);

            if (!empty($disponible)) {
                echo json_encode(array('respuesta' => false, 'code' => 'noDisponible'));
            } else {
                $insert = $informesControl->RegistrarInforme($miInforme);
                if ($insert != '') {
                    echo json_encode(array('respuesta' => true, 'informe' => $insert));
                } else {
                    echo json_encode(array('respuesta' => false, 'informe' => ''));
                }
            }
            break;
        case 'actualizarInforme':
            $informesControl = new InformesCL();
            
            $empleadosControl = new \Application\Controllers\EmpleadosCL();
            $infoEmpleado = $empleadosControl->ConsultaDetallesEmpleado($IdResponsable);

            $codiciones = [
                'calibracion' => [
                    'fecha' =>$FechaCalibracion,
                    'recepcion' => $FechaRecepcion,
                    'lugar' => $lugar,
                    'ingeniero' =>[
                        'cedula' => $infoEmpleado[0]->cedula,
                        'nombre' => $infoEmpleado[0]->nombres .' '.$infoEmpleado[0]->apellidos,
                        'cargo' => $infoEmpleado[0]->cargo
                    ],
                    'humedad' => ['inicial' =>(float)$humedadInicial, 'final' =>(float)$humedadFinal],
                    'temperatura' => ['inicial' => (float)$temperaturaInicial, 'final' => (float)$humedadInicial]
                ],
                'observaciones' => $observa
            ];

            $actualiza = $informesControl->ActualizarDetallesInforme($idInforme, $codiciones);


            if ($actualiza > 0) {
                echo json_encode(array('respuesta' => true, 'informe' => $idInforme));
            } else {
                echo json_encode(array('respuesta' => false, 'informe' => $idInforme));
            }
        break;

        case 'eliminaInforme':
            $informesControl = new InformesCL();
            $eject=$informesControl->EliminarInforme($idInfo);
            echo json_encode(array('respuesta' => $eject, 'code'=>'elimina'));
        break;
        case 'infoInforme':
            $informeControl = new InformesCL();
            $certificado = $informeControl->ConsultarDetalleInforme($idInfo);
            ?>
            <table class="table">
                <tr>
                    <th colspan="4" style="text-align: center">Info Cliente</th>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php 
                            echo $certificado->cliente->nombre.'<br>';
                            echo $certificado->cliente->direccion.'<br>';  
                            echo $certificado->cliente->departamento.' '.$certificado->cliente->ciudad.'<br>';
                        ?>     
                    </td>
                </tr>
                <tr>
                    <th colspan="4" style="text-align: center">Info Equipo</th>
                </tr>
                <tr>
                   <td colspan="4">
                        <?php 
                            echo $certificado->equipo->tipo.' '.$certificado->equipo->marca.'<br>';  
                            echo $certificado->equipo->modelo.' '.$certificado->equipo->serie.'<br>';
                        ?>     
                    </td>
                </tr>
                <tr>
                    <th colspan="4" style="text-align: center">Info Calibracion</th>
                </tr>
                <tr>
                    <th colspan="2">Lugar</th>
                    <td colspan="2"><?php echo $certificado->calibracion->lugar ?></td>
                </tr>
                <tr>
                    <th>Calibracion</th>
                    <td><?php echo $certificado->calibracion->fecha ?></td>
                    <th>Recepcion</th>
                    <td><?php echo $certificado->calibracion->recepcion ?></td>
                </tr>
                <tr>
                    <th>Temperatura</th>
                    <td><?php echo $certificado->calibracion->humedad->inicial . " - " . $certificado->calibracion->humedad->final; ?></td>
                    <th>Humedad</th>
                    <td><?php echo $certificado->calibracion->temperatura->inicial . " - " . $certificado->calibracion->temperatura->inicial; ?></td>
                </tr>
                <tr>
                    <th>Registro</th>
                    <td colspan="3"><?php echo $certificado->usuario->nombre ?></td>
                </tr>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center">Parametros</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            <?php
            break;
        default:
            echo "Accion no Programada";
            break;
    }
}
<?php

/*
 * Copyright (C) 2018 Sistemas 
 * Gnesis App - CR EQUIPOS SA
 * 
 * Archivo Creado por Zeraling
 */

//importa la ruta global
require_once './settings/baseUrl.php';
//incluye la carga automatica de dependencias 
include_once './vendor/autoload.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

//nombra la session 
session_name("caliperUser");
//inicia la session
session_start();

//define vairables glogal de usuarios y acceso
$dataUser = [];
$dataAcces = [];
$keyAcces = '';

//define vairable glogal de rutas
$viewSystem = isset($_GET['view']) ? $_GET['view'] : '/';
//instancia del controlador de rutas
$router = new RouteCollector();
// Any thing other than null returned from a filter will prevent the route handler from being dispatched
if (isset($_SESSION['calLogKey']) && ($viewSystem == $_SESSION['calLogKey'])) {
    session_destroy(); // destruyo la sesión 
    header("Location: " . BASE_URL); //envío al usuario a la pag. de autenticación  
} elseif (empty($_SESSION['calLogKey']) || empty($_SESSION['calUser'])) {
    if ($viewSystem != '/') {
        header("Location: " . BASE_URL); //envío al usuario a la pag. de autenticación  
    } else {
        $router->controller('/', Application\Views\InicioSesionPage::class);
    }
} else {
    // isntancias de usuario y funciones
    $empleado = new \Application\Controllers\EmpleadosCL();
    $funciones = new \Application\Controllers\FuncionesempleadosCL();
    // define llave de acceso
    $keyAcces = $_SESSION['calLogKey'];
    // define fecha de acceso
    $fechaGuardada = $_SESSION["calLastAcces"];
    $ahora = date("Y-m-d H:i:s");
    $tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));

    //comparamos el tiempo transcurrido, si pasaron 10 minutos o más 
    if ($tiempo_transcurrido >= 6000) {
        session_destroy(); // destruyo la sesión 
        header("Location: " . BASE_URL); //envío al usuario a la pag. de autenticación  
    } else {
        //sino, actualizo la fecha de la sesión 
        $_SESSION["calLastAcces"] = $ahora;
        // se establece el codigo del usuario
        $idUser = !empty($_SESSION['calUser']) ? json_decode(base64_decode($_SESSION['calUser'])) : 0;
        // se consultan los datos de l usuario 
        $dataUser = $empleado->ConsultaDetallesEmpleado($idUser);
        // se consultan las funciones asigandas al usuario 
        $dataAcces = (gettype($dataUser) == 'array') ? $funciones->ConsultaPermisosAsignados($dataUser[0]->cedula) : array();
        $menuOptions = json_decode(file_get_contents('settings/infoMenu.json'));
        if (!empty($menuOptions)) {
            $viewSystem=($dataUser[0]->estado_clave == 0 ? '/' : $viewSystem);
            $pageRender = Application\DynamicView::stateViewMenu($menuOptions, $viewSystem);
            $router->controller($pageRender['pageLink'], Application\DynamicView::get($pageRender['pageClass']));
        } else {
            die('no se cargaron las opciones del menu');
        }
    }
}
//generar vistas de aplicacion
try {
    $dispatcher = new Dispatcher($router->getData());
    echo $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $viewSystem);
} catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $errorExp) {
    include_once './template/errors/404.php';
} catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $errorExp) {
    include_once './template/errors/405.php';
}

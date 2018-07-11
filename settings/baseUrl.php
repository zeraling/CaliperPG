<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Sigledo App - Radproct Ltda
 *
 *  Archivo Creado por Zeraling
 */

$baseUrl = function () {
    //establecer la ruta glopal base del proyecto
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

    $rootApp = str_replace(array('public/', 'application/server/', 'reports/'), '', $baseDir);

    $host = array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : gethostbyaddr($_SERVER["REMOTE_ADDR"]);
    return $protocol . $host . $rootApp;
};

define('BASE_URL', $baseUrl());
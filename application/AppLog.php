<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLog {

    private static $_logger = null;

    private static function getLogger() {
        if (!self::$_logger) {
            self::$_logger = new Logger('Gnesis Log');
        }

        return self::$_logger;
    }

    public static function logDebug($mensaje, $file, $line) {
        self::getLogger()->pushHandler(new StreamHandler(__DIR__ . '/application.log'));
        self::getLogger()->addInfo($mensaje);
        self::getLogger()->addError('Archivo: ' . $file);
        self::getLogger()->addDebug('Linea de Error: ' . $line);
    }

}

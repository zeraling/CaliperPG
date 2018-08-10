<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  CaliperPG App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Connections;

/**
 * Description of CaliperMongo
 *
 * @author Usuario
 */
class CaliperMongo extends \MongoDB\Client {

    //put your code here
    function __construct() {

        $hostname = '127.0.0.1';
        $port = '27017';
        $username = 'appCaliper';
        $password = 'xyz123';

        try {
            $stringCon = "mongodb://" . $username . ":" . $password . "@" . $hostname . ":" . $port . "/caliper";
            parent::__construct($stringCon,[],[]);
        } catch (\MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            var_dump($e);
        }
    }

}

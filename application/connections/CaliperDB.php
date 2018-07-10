<?php

/*
 * Copyright (C) 2018 Sistemas CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Connections;
use PDO;
/**
 * Description of CaliperDB
 * PostgreSQL
 * @author Usuario
 */
class CaliperDB extends PDO { 
    
   private $dataBase = 'caliper';
   
   public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      $config = parse_ini_file(dirname(__DIR__,2) . '/settings/infoAcces.ini');
      try{
         parent::__construct('pgsql:host='.$config['server_app'].';port='.$config['server_port'].';dbname='.$this->dataBase.';user='.$config['user_app'].';password='.$config['user_pass']);
         parent::setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      }catch(\PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   }
}

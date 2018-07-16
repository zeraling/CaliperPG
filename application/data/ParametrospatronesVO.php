<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application\Data;

/**
 * Description of ParametrospatronesVO
 *
 * @author Usuario
 */
class ParametrospatronesVO {

    //put your code here

    private $id;
    private $cod_patron;
    private $cod_prueba;
    private $id_parametro;
    private $id_unidad;
    private $incertidumbre;
    private $resolucion;
    private $valor_tolerancia;
    private $unidad_tolerancia;

    function getId() {
        return $this->id;
    }

    function getCod_patron() {
        return $this->cod_patron;
    }

    function getCod_prueba() {
        return $this->cod_prueba;
    }

    function getId_parametro() {
        return $this->id_parametro;
    }

    function getId_unidad() {
        return $this->id_unidad;
    }

    function getIncertidumbre() {
        return $this->incertidumbre;
    }

    function getResolucion() {
        return $this->resolucion;
    }

    function getValor_tolerancia() {
        return $this->valor_tolerancia;
    }

    function getUnidad_tolerancia() {
        return $this->unidad_tolerancia;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCod_patron($cod_patron) {
        $this->cod_patron = $cod_patron;
    }

    function setCod_prueba($cod_prueba) {
        $this->cod_prueba = $cod_prueba;
    }

    function setId_parametro($id_parametro) {
        $this->id_parametro = $id_parametro;
    }

    function setId_unidad($id_unidad) {
        $this->id_unidad = $id_unidad;
    }

    function setIncertidumbre($incertidumbre) {
        $this->incertidumbre = $incertidumbre;
    }

    function setResolucion($resolucion) {
        $this->resolucion = $resolucion;
    }

    function setValor_tolerancia($valor_tolerancia) {
        $this->valor_tolerancia = $valor_tolerancia;
    }

    function setUnidad_tolerancia($unidad_tolerancia) {
        $this->unidad_tolerancia = $unidad_tolerancia;
    }

}

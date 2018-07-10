<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application;

/**
 * Description of CustomTools
 *
 * @author Usuario
 */
class CustomFunctions {

    //put your code here

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function BuscarEnArray($arrar, $grupo) {
        for ($i = 0; $i < count($arrar); $i++) {
            if ($arrar[$i] == $grupo) {
                return true;
            }
        }
        return false;
    }

    public function limpiarString($string) {

        $string = trim($string);
        $string = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string);
        $string = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string);
        $string = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string);
        $string = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string);
        $string = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string);
        $string = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string);
        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(array("¨", "º", "-", "~", "#", "@", "|", "!", "", "·", "$", "%", "&", "/", "(", ")", "?", "'", "¡", "¿", "[", "^", "<code>", "]", "+", "}", "{", "¨", "´", ">", "< ", ";", ",", ":", "."), '', $string);
        $string = str_replace(array("/"), '_', $string);
        return $string;
    }

    public function formatMes($mNumber) {
        switch ($mNumber) {
            case "01" :
                return $stringmonth = "Enero";
            case "02" :
                return $stringmonth = "Febrero";
            case "03" :
                return $stringmonth = "Marzo";
            case "04" :
                return $stringmonth = "Abril";
            case "05" :
                return $stringmonth = "Mayo";
            case "06" :
                return $stringmonth = "Junio";
            case "07" :
                return $stringmonth = "Julio";
            case "08" :
                return $stringmonth = "Agosto";
            case "09" :
                return $stringmonth = "Septiembre";
            case "10" :
                return $stringmonth = "Octubre";
            case "11" :
                return $stringmonth = "Noviembre";
            case "12" :
                return $stringmonth = "Diciembre";
        }
    }

}

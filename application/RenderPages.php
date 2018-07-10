<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application;

class RenderPages {

    protected $templateEngine;

    public function __construct() {
        global $dataUser;
        global $dataAcces;
        global $keyAcces;
        global $menuOptions;

        $loader = new \Twig_Loader_Filesystem('public'); //folder de vistas
        $this->templateEngine = new \Twig_Environment($loader, [
            'charset' => 'utf-8', 'cache' => false,
            'debug' => true,
        ]);

        $this->templateEngine->addGlobal('loginKey', $keyAcces);

        if (!empty($dataUser)) {
            $this->templateEngine->addGlobal('dtaUser', $dataUser[0]);
            $this->templateEngine->addGlobal('userCode', base64_encode($dataUser[0]->cedula));
            $this->templateEngine->addGlobal('menuOptions', $menuOptions);
        }

        if (!empty($dataAcces)) {
            $this->templateEngine->addGlobal('dtaAcces', $dataAcces);
        }

        $this->templateEngine->addExtension(new \Twig_Extension_Debug());
        $this->templateEngine->addFilter(new \Twig_SimpleFilter('baseUrl', function ($path) {
            return BASE_URL . $path;
        }));
        
        $this->templateEngine->addFunction(new \Twig_Function('fechaHora', function ($date, $opcion = false) {
            if ($opcion) {
                $fecha = date('Y-m-d', strtotime($date)) . ' ' . strftime("%I:%M %p", strtotime($date));
            } else {
                $fecha = date('d/m/Y', strtotime($date)) . ' ' . strftime("%I:%M %p", strtotime($date));
            }
            return $fecha;
        }));
    }

    public function render($fileName, $data = []) {
        try {
            return $this->templateEngine->render($fileName, $data);
        } catch (\Twig_Error $exc) {
            echo '<pre>' . $exc . '</pre>';
        }
    }

}

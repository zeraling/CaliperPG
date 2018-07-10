<?php

/*
 *  Copyright (C) 2018 Sistemas 
 *  Gnesis App - CR EQUIPOS SA
 *
 *  Archivo Creado por Zeraling
 */

namespace Application;

/**
 * Description of ContainerViews
 *
 * @author Usuario
 */
class DynamicView {

    //put your code here
    static protected $registry = [];
    static protected $navegacion = [];

    public static function get($key) {
        if (!array_key_exists($key, static::$registry)) {
            static::$registry[$key] = new $key;
        }
        return static::$registry[$key];
    }

    private static function reverse_strrchr($haystack, $needle) {
        $pos = strrpos($haystack, $needle);
        if ($pos === false) {
            return $haystack;
        }
        return trim(substr($haystack, 0, $pos + 1), '/');
    }

    public static function stateViewMenu($menu, $viewCarga) {
        $pageClass = 'Application\Views\DashBoardPage';
        $pageLink = '/';
        if ($viewCarga != '/') {
            $view = self::reverse_strrchr($viewCarga, '/');
            $partView = explode('/', $view);
            foreach ($menu as $values) {
                if (in_array($partView[0], $values->vistas)) {
                    $values->stateMenu = true;
                    if (count($values->opciones) > 0 && count($values->vistas) > 0) {
                        foreach ($values->opciones as $items) {
                            $subView = isset($partView[1]) ? '/' . $partView[1] : '';
                            if (in_array($partView[0] . $subView, $items->vistas)) {
                                $items->stateSubmenu = in_array($view, $items->vistas);
                                $pageLink = '/' . $items->link;
                                $pageClass = 'Application\Views\\' . $items->class;
                                break;
                            }
                        }
                    } else {
                        $pageLink = '/' . $values->link;
                        $pageClass = 'Application\Views\\' . $values->class;
                    }
                    break;
                }
            }
        } else {
            $menu[0]->stateMenu = true;
        }

        static::$navegacion = ['pageClass' => $pageClass, 'pageLink' => $pageLink, 'menuState' => $menu];
        return static::$navegacion;
    }
    
}

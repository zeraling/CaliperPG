<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Views;

use Application\RenderPages;
/**
 * Description of AuthController
 *
 * @author Usuario
 */
class InicioSesionPage extends RenderPages {
    //put your code here
    public function getIndex() {
        return $this->render('pageLogin.twig');
    }
}

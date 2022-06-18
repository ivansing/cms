<?php

namespace App\Controllers;

use Core\Controller;

class CursosController extends Controller {
    
    public function indexAction($param1, $param2) {
        die("Hizo la accion de indice {$param1} {$param2}");
    }

    public function fooAction() {
        die("Hizo la acción de foo");
    }
}
<?php

namespace Core;

use App\Controllers\CursosController;

// Router class to call all controllers

class Router {

    public static function route($url) {
        
        $controller = new CursosController('Cursos', 'indexAction');
        
    }
}
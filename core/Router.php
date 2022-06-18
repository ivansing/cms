<?php

namespace Core;

use App\Controllers\CursosController;

// Router class to call all controllers

class Router {

    public static function route($url) {
        $urlParts = explode('/', $url);
       
        // set controller name  in url
        $controller = !empty($urlParts[0]) ? $urlParts[0] : Config::get('default_controller');
        $controllerName = $controller;
        $controller = '\App\Controllers\\' . ucwords($controller) . 'Controller';
        
        // set action
        array_shift($urlParts);
        $action = !empty($urlParts[0]) ? $urlParts[0] : 'index';
        $actionName = $action;
        $action .= 'Action';
        array_shift($urlParts);

        $controllerClass = new $controller($controllerName, $actionName);
        call_user_func_array([$controllerClass, $action], $urlParts);
        var_dump($controllerClass);
        $controller = new CursosController('Cursos', 'indexAction');
        
    }
}
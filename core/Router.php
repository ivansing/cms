<?php

namespace Core;




// Router class to call all controllers

class Router {

    public static function route($url) {
        $urlParts = explode('/', $url);
       
        // set controller name  in url
        $controller = !empty($urlParts[0])? $urlParts[0] : Config::get('default_controller');
        $controllerName = $controller;
        $controller = '\App\Controllers\\' . ucwords($controller) . 'Controller';
        
        // set action
        array_shift($urlParts);
        $action = !empty($urlParts[0]) ? $urlParts[0] : 'index';
        $actionName = $action;
        $action .= 'Action';
        array_shift($urlParts);

        // check if a class exist
        if(!class_exists($controller)) {
            throw new \Exception("The controller \"{$controllerName}\" does not exist ");
        }
        $controllerClass = new $controller($controllerName, $actionName);

        // if class action exist in the object $controller if not kill exucution script with throw exception
        if (!method_exists($controllerClass, $action)) {
            throw new \Exception("The method \"{$action}\" does not exit on the \"{$controller}\" controller.");
            
        }
        call_user_func_array([$controllerClass, $action], $urlParts);
 
        
        
    }

    
}
<?php 
 session_start();
 // Use to autoload classes 
 use \Core\{Config, Router};

 // define constants
 
 // This give us the exact path in the server
 define('PROOT', __DIR__);

 // Separator \ windows server and linux /
 define('DS', DIRECTORY_SEPARATOR);

 // Autoload classes in the array and build the full path
 spl_autoload_register(function($className){
    $parts = explode('\\', $className);
    $class = end($parts);
    array_pop($parts);
    $path = strtolower(implode(DS, $parts));
    $path = PROOT . DS . $path . DS . $class . '.php';
    if(file_exists($path)) {
        include($path);
    }
    
 });

 // To get root directory path
 $rootDir = Config::get('root_dir');
 define('ROOT', $rootDir);

 // Replace remove any charaters from the nav bar
 $url = $_SERVER['REQUEST_URI'];
 $url = str_replace(ROOT, '', $url);
 $url = preg_replace('/(\?.+)/', '', $url);
 Router::route($url);

 
 
 
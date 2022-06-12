<?php 
 session_start();
 // will grab namespace core
 use \Core\Config;

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

 $dbName = Config::get('db_name');
 var_dump($dbName);
 
 
 // use for debug purposes
 //var_dump(DS);
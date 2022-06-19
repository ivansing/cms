<?php
namespace Core;

use Core\Config;

class View {
    private $_siteTitle = '', $_content = [], $_currentContent, $_buffer, $_layout;
    private $_defaultViewPath;

    public function __construct($path = '') {
        $this->_defaultViewPath = $path;
        $this->_siteTitle = Config::get('default_site_title');
       
    }

    public function setLayout($layout) {
        $this->_layout = $layout;
    }

    public function render($path = '') {
        if(empty($path)) {
            $path = $this->_defaultViewPath;
        }
        $fullPath = PROOT . DS . 'app' . DS . 'views' . DS  . $path . '.php';
        $layoutPath = PROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout  . '.php'; 
        
        if(!file_exists($fullPath)) {
            throw new \Exception("The view \"{$path}\" does not exist.");
        }
        if(!file_exists($layoutPath)) {
            throw new \Exception("The view \"{$this->_layout}\" does not exist.");
        }
        //var_dump($fullPath);
        include($fullPath);
        include($layoutPath);
    }  
}
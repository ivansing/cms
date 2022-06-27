<?php

namespace App\Controllers;

use Core\{DB, Controller, Helpers};

class CursoController extends Controller {
    
    public function indexAction(){
        $db = DB::getInstance();
        
        $this->view->setSiteTitle('Nuevos Cursos');
        $this->view->render();
    }
    
}
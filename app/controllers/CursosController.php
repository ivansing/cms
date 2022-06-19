<?php

namespace App\Controllers;

use Core\Controller;

class CursosController extends Controller {
    
    public function indexAction(){
        $this->view->setSiteTitle('Nuevos Cursos');
        $this->view->render();
    }

    

    
}
<?php 

namespace App\Controllers;

use Core\{DB, Controller, H};

class CursoController extends Controller {

    public function indexAction(){
        $db = DB::getInstance();
        
        $this->view->setSiteTitle('Nuevos cursos');
        $this->view->render();
    }
    
}

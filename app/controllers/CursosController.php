<?php

namespace App\Controllers;

use Core\{DB, Controller, Helpers};

class CursosController extends Controller {
    
    public function indexAction(){
        $db = DB::getInstance();
       // Helpers::dnd($db, false); debug
        $this->view->setSiteTitle('Nuevos Cursos');
        $this->view->render();
    }

    

    
}
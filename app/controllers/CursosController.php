<?php

namespace App\Controllers;

use Core\{DB, Controller, Helpers};

class CursosController extends Controller {
    
    public function indexAction(){
        $db = DB::getInstance();
        $sql = "INSERT INTO cursos (`title`, `body`) VALUES (:title, :body)";
        $bind = ['title' => 'nuevo curso', 'body' => 'cursos body'];
        $query = $db->execute($sql, $bind);
        $lastId = $query->lastInsertId();
        Helpers::dnd($lastId);
        /* $sql = "SELECT * FROM  cursos";
        $query = $db->query($sql);
        $cursos = $db->query($sql, )->getResults();
        $count = $query->getLastInsertId();
        Helpers::dnd($count);*/
        $this->view->setSiteTitle('Nuevos Cursos');
        $this->view->render();
    }
    
}
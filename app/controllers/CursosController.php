<?php

namespace App\Controllers;

use Core\{DB, Controller, Helpers};

class CursosController extends Controller {
    
    public function indexAction(){
        $db = DB::getInstance();
        /* $sql = "INSERT INTO cursos (`title`, `body`) VALUES (:title, :body)";
        $bind = ['title' => 'nuevo curso', 'body' => 'cursos body'];
        $query = $db->execute($sql, $bind);
        $lastId = $query->lastInsertId(); */
       // $db->insert('cursos', ['title' => 'curso', 'body' => 'descripcion curso']);
        $db->update('cursos', ['user_id' => 1], ['id' => 18]);
        $this->view->setSiteTitle('Nuevos Cursos');
        $this->view->render();
    }
    
}
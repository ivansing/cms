<?php
namespace App\Controllers;
use Core\{Controller, Session, Router};
use App\Models\{Users};

class AdminController extends Controller {

    public function onConstruct(){
        $this->view->setLayout('admin');
        $this->currentUser = Users::getCurrentUser();
    }

    // Get list of cursos
    public function cursosAction() {
        $this->view->render();
    }

    // Get all the users
    public function usersAction() {
        $allowed = $this->currentUser->hasPermission('admin');
         if(!$allowed) {
            Session::msg("No tiene acceso a esta pagina.");
            Router::redirect('admin/cursos');
        } 
        $params = ['order' => 'lname', 'fname'];
        $params = Users::mergeWithPagination($params);
        $this->view->users = Users::find($params);
        $this->view->total = Users::findTotal($params);
        $this->view->render();
    }
}
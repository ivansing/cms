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
        Router::permRedirect(['usuario', 'admin'], 'curso/index');
        $this->view->render();
    }

    // Get all the users
    public function usersAction() {
        Router::permRedirect('admin', 'admin/cursos');
        $params = ['order' => 'lname', 'fname'];
        $params = Users::mergeWithPagination($params);
        $this->view->users = Users::find($params);
        $this->view->total = Users::findTotal($params);
        $this->view->render();
    }

    public function toggleBlockUserAction($userId) {
        Router::permRedirect('admin', 'admin/cursos');
        $user = Users::findById($userId);
        if($user) {
            $user->blocked = $user->blocked? 0 : 1;
            $user->save();
            $msg = $user->blocked? "Usuario bloqueado" : "Usuario desbloqueado";
        }
        Session::msg($mgs, 'sucess');
        Router::redirect('admin/users');
    }

    public function deleteUserAction($userId) {
        Router::permRedirect('admin', 'admin/cursos');
        $user = Users::findById($userId);
        $msgType = 'danger';
        $msg = 'El usuario no se puede borrar';
        if($user && $user->id !== Users::getCurrentUser()->id) {
            $user->delete();
            $msgType = 'sucess';
            $msg = 'Usuario borrado';
        }
        Session::msg($msg, $msgType);
        Router::redirect('admin/users');
    }
}
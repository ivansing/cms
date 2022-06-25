<?php
namespace App\Controllers;

use Core\{Controller, Helpers, Session, Router, Request};
use App\Models\Users;

class AuthController extends Controller {
    
    public  function registerAction($id = 'new') {
        if($id == 'new') {
            $user = new Users();
        } else {
            $user = Users::findById($id);
        }

        // Check if posted any data
        if($this->request->isPost()) {
            Helpers::dnd($this->request->get());
        }

        $this->view->user = $user;
        $this->view->role_options = ['' => '', Users::USER_PERMISSION => 'Usuario', Users::ADMIN_PERMISSION => 'Administrador']; 
        $this->view->errors = $user->getErrors();
        $this->view->render();
    }
}
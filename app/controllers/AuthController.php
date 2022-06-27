<?php
namespace App\Controllers;

use Core\{Controller, Helpers, Session, Router, Request};
use App\Models\Users;

class AuthController extends Controller {
    
    public  function registerAction($id = 'new') {
        if($id == 'new') {
            $user = new Users();
        } else {
            // Find User by id in the auth/register
            $user = Users::findById($id);
        }

        if(!$user) {
            Session::msg("No tiene permiso para editar este usuario");
            Router::redirect('curso/index');
        }
        
        // Check if posted any data
        if($this->request->isPost()) {
            // Method to prevent X site attack when feeling the form
            Session::csrfCheck();
            $fields = ['fname', 'lname', 'email', 'acl', 'password', 'confirm'];
            foreach($fields as $field) {
                 $user->{$field} = $this->request->get($field);
            }
            // Save user 
            if($id != 'new' && !empty($user->password)) {
                $user->resetPassword = true;
            }
            if($user->save()) {
                $msg = ($id == 'new') ? "Usuario creado." : "Usuario actualizado";
                Session::msg($msg, 'success');
                Router::redirect('curso/index');
            }

        }

        // Add or edit user in the register page
        $this->view->header = $id == 'new'? 'Agregar nuevo usuario' : 'Editar Usuario';
       
        $this->view->user = $user;
        $this->view->role_options = ['' => '', Users::USER_PERMISSION => 'Usuario', Users::ADMIN_PERMISSION => 'Administrador']; 
        $this->view->errors = $user->getErrors();
        $this->view->render();
    }
}
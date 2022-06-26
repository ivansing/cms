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
        

       // Helpers::dnd($user);

        // Check if posted any data
        if($this->request->isPost()) {
            // Method to prevent X site attack when feeling the form
            Session::csrfCheck();
            $fields = ['fname', 'lname', 'email', 'acl', 'password', 'confirm'];
            foreach($fields as $field) {
                 $user->{$field} = $this->request->get($field);
            }
            // Save user 
            $user->save();

        }

        $this->view->user = $user;
        $this->view->role_options = ['' => '', Users::USER_PERMISSION => 'Usuario', Users::ADMIN_PERMISSION => 'Administrador']; 
        $this->view->errors = $user->getErrors();
        $this->view->render();
    }
}
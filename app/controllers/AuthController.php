<?php
namespace App\Controllers;

use Core\{Controller, Helpers, Session, Router, Request};
use App\Models\Users;

class AuthController extends Controller {
    
    public function registerAction($id = 'new') {
        if($id == 'new') {
            $user = new Users();
        } else {
            $user = Users::findById($id);
        }

        if(!$user) {
            Session::msg("You do not have permission to edit this user");
            Router::redirect('curso/index');
        }

        // if posted
        if($this->request->isPost()){
            Session::csrfCheck();
            $fields = ['fname', 'lname', 'email', 'acl', 'password', 'confirm'];
            foreach($fields as $field) {
                $user->{$field} = $this->request->get($field);
            }
            if($id != 'new' && !empty($user->password)) {
                $user->resetPassword = true;
            }
            if($user->save()) {
                $msg = ($id == 'new')? "Usuario creado." : "Usuario actualizado";
                Session::msg($msg, 'success');
                Router::redirect('curso/index');
            }
            
        }
        $this->view->header = $id == 'new'? 'Agregar Usuario' : 'Editar Usuario';
        $this->view->user = $user;
        $this->view->role_options = ['' => '', Users::USER_PERMISSION => 'Usuario', Users::ADMIN_PERMISSION => 'Administrador'];
        $this->view->errors = $user->getErrors();
        $this->view->render();
    }

    public function loginAction(){
        $user = new Users();
        $isError = true;

        if($this->request->isPost()) {
            Session::csrfCheck();
            $user->email = $this->request->get('email');
            $user->password = $this->request->get('password');
            $user->remember = $this->request->get('remember');
            $user->validateLogin();
            if(empty($user->getErrors())){
                //continue with the login process
                $u = Users::findFirst([
                    'conditions' => "email = :email", 
                    'bind' => ['email' => $this->request->get('email')]
                ]);
                if($u) {
                    $verified = password_verify($this->request->get('password'), $u->password);
                    if($verified) {
                        //log the user in
                        $isError = false;
                        $remember = $this->request->get('remember') == 'on';
                        $u->login($remember);
                        Router::redirect('');
                    }
                }
            }
            if($isError) {
                $user->setError('email', 'Algo salio mal con el email o la contraseaña. Trate otra vez por favor.');
                $user->setError('password', '');
            }
        }

        $this->view->errors = $user->getErrors();
        $this->view->user = $user;
        $this->view->render();
    }
}
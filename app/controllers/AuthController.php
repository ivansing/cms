<?php
namespace App\Controllers;

use Core\{Controller, Helpers, Session, Router};

class AuthController extends Controller {
    
    public  function registerAction($id = 'new') {
        $this->view->errors = [];
        $this->view->render();
    }
}
<?php 
namespace App\Models;

use Core\{Model, Session, Cookie};
use Core\Validators\{RequiredValidator, EmailValidator, MatchesValidator, MinValidator, UniqueValidator};

class Users extends Model {

    protected static $table = 'users', $_current_user = false;
    public $id, $created_at, $updated_at, $fname, $lname, $email, $password, $acl, $blocked = 0, $confirm, $remember = '';

    const USER_PERMISSION = 'usuario';
    const ADMIN_PERMISSION = 'administrador';

    public function beforeSave() {
        $this->timeStamps();

        // Validations form fields
        $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => "El primer nombre es un campo requerido"]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => "El apellindo es un campo requerido"]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => "El correo electronico es un campo requerido"]));
        $this->runValidation(new Emailvalidator($this, ['field' => 'email', 'msg' => "Debe proveer un email valido"]));
        $this->runValidation(new UniqueValidator($this, ['field' => ['email', 'acl', 'lname'],  'msg' => "El usuario ya existe"]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'acl', 'msg' => "La función  es un campo requerido"]));

        // If user is new ? save all the fields
        if($this->isNew() || $this->resetPassword) {
            $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => "La contraseña es un campo requerido"]));
            $this->runValidation(new RequiredValidator($this, ['field' => 'confirm', 'msg' => "La confirmación contraseña  es un campo requerido"]));
            $this->runValidation(new MatchesValidator($this, ['field' => 'confirm', 'rule' => $this->password, 'msg' => "Su contraseña no coincide"]));
            $this->runValidation(new MinValidator($this, ['field' => 'password', 'rule' => 8, 'msg' => "La contraseña debe ser de al menos 8 caracteres"]));

            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        } else {

            // Not update password
            $this->_skipUpdate = ['password'];
        }
    }

    // Validate Login
    public function validateLogin(){
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => "El correo electronico es un campo requerido"]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => "La contraseña es un campo requerido"]));

    }

    // Remember session
    public function login($remember = false) {
        Session::set('logged_in_user', $this->id);
        self::$_current_user = $this;
    } 
        
}  

<?php 
namespace App\Models;

use Core\Model;
use Core\Validators\{RequiredValidator, EmailValidator, MatchesValidator};

class Users extends Model {

    protected static $table = 'users';
    public $id, $created_at, $updated_at, $fname, $lname, $email, $password, $acl, $blocked = 0, $confirm, $remember = '';

    const USER_PERMISSION = 'usuario';
    const ADMIN_PERMISSION = 'administrador';

    public function beforeSave() {
        $this->timeStamps();

        $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => "El primer nombre es un campo requerido"]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => "El apellindo es un campo requerido"]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => "El correo electronico es un campo requerido"]));
        $this->runValidation(new Emailvalidator($this, ['field' => 'email', 'msg' => "Debe proveer un email valido"]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'acl', 'msg' => "La función  es un campo requerido"]));

        // If user is new ? save password with security
        if($this->isNew()) {
            $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => "La contraseña es un campo requerido"]));
            $this->runValidation(new RequiredValidator($this, ['field' => 'confirm', 'msg' => "La confirmación contraseña  es un campo requerido"]));
            $this->runValidation(new MatchesValidator($this, ['field' => 'confirm', 'rule' => $this->password, 'msg' => "Su contraseña no coincide"]));

            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        } 
    }
}
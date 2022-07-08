<?php 
namespace App\Models;

use Core\{Model, Session, Cookie, Config, H};
use Core\Validators\{RequiredValidator, EmailValidator, MatchesValidator, MinValidator, UniqueValidator};
use App\Models\UserSessions;

class Users extends Model {
    protected static $table = "users", $_current_user = false;
    public $id, $created_at, $updated_at, $fname, $lname, $email, $password, $acl, $blocked = 0, $confirm, $remember = '';


    const USER_PERMISSION = 'usuario';
    const ADMIN_PERMISSION = 'admin';

    public function beforeSave(){
        $this->timeStamps();

        $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => "El primer nombre es un campo requerido."]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => "El apellido es un campo requerido."]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => "El correo electronico es un campo requerido."]));
        $this->runValidation(new EmailValidator($this, ['field' => 'email', 'msg' => 'Debe proveer un email valido.']));
        $this->runValidation(new UniqueValidator($this, ['field' => ['email','acl', 'lname'], 'msg' => 'Un usuario con este email ya existe.']));
        $this->runValidation(new RequiredValidator($this, ['field' => 'acl', 'msg' => "La función  es un campo requerido."]));
        if($this->isNew() || $this->resetPassword) {
            $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => "La contraseña es un campo requerido."]));
            $this->runValidation(new RequiredValidator($this, ['field' => 'confirm', 'msg' => "La confirmación contraseña  es un campo requerido."]));
            $this->runValidation(new MatchesValidator($this, ['field' => 'confirm', 'rule' => $this->password, 'msg' => "Su contraseña no coinciden."]));
            $this->runValidation(new MinValidator($this, ['field' => 'password', 'rule' => 6, 'msg' => "La contraseña debe ser de al menos 6 caracteres."]));

            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        } else {
            $this->_skipUpdate = ['password'];
        }
    }

    public function validateLogin(){
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => "El correo electronico es un campo requerido."]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => "La contraseña es un campo requerido."]));
    }

    // Login method db
    public function login($remember = false) {
        Session::set('logged_in_user', $this->id);
        self::$_current_user = $this;
        if($remember) {
            $now  = time();
            $newHash = md5("{$this->id}_{$now}");
            $session = UserSessions::findByUserId($this->id);
            if(!$session) {
                $session = new UserSessions();
            }
            $session->user_id = $this->id;
            $session->hash = $newHash;
            $session->save();
            Cookie::set(Config::get('login_cookie_name'), $newHash, 60 * 60 * 24 * 30);
        }
    }

    //  Finds the user cookie to login in the db
    public static function loginFromCookie() {
        $cookieName = Config::get('login_cookie_name');
        if(!Cookie::exists($cookieName)) return false;
        $hash = Cookie::get($cookieName);
        $session = UserSessions::findByHash($hash);
        if(!$session) return false;
        $user = self::findById($session->user_id);
        if($user) {
            $user->login(true);
        }
    }

    // Log out session
    public function logout(){
        Session::delete('logged_in_user');
        self::$_current_user = false;
        $session = UserSessions::findByUserId($this->id);
        if($session) {
            $session->delete();
        }
        Cookie::delete(Config::get('login_cookie_name'));
    }

    // Get current user id from session
    public static function getCurrentUser() {
        if(!self::$_current_user && Session::exists('logged_in_user')) {
            $user_id = Session::get('logged_in_user');
            self::$_current_user = self::findById($user_id);
        }
        if(!self::$_current_user) self::loginFromCookie();
        // If the user is blocked
        if(self::$_current_user && self::$_current_user->blocked) {
            self::$_current_user->logout();
            Session::msg('Esta bloqueado. Contactarse con el administrador por favor.');
        }
        return self::$_current_user;
    }

    // Allowed user session in admin
    public function hasPermission($acl) {
        if(\is_array($acl)) {
            return in_array($this->acl, $acl);
        }
        return $this->acl == $acl;
    }

    // Display names on portal
    public function displayName(){
        return trim($this->fname . ' ' . $this->lname);
    }
}
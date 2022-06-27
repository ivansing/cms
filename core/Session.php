<?php
namespace Core;
use Core\{Request, Helpers};

class Session {
    public static function exists($name) {
        return isset($_SESSION[$name]);
    }

    // Set Cookie
    public static function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    // Get Cookie
    public static function get($name) {
        if(self::exists($name) && !empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return false;
    }

    // Delete cookied
    public static function delete($name) {
        unset($_SESSION[$name]);
    }

    // Token generator to prevent Cross site attack
    public static function createCsrfToken(){
        $token = md5('csrf' .time());
        self::set('csftToken', $token);
        return $token;
    }

    // Cross site prevent attack method
    public static function csrfCheck(){
        $request = new Request();
        $check = $request->get('csrfToken');
        if(self::exists('csrfToken') && self::get('csrfToken') == $check){
            return true;
        }

        // Redirect page with no token
        //Router::redirect('auth/badToken');
       
    }

    // Setting message primary, secondary, sucess, danger, info
    public static function msg($msg, $type = 'danger'){
        $alerts = self::exists('session(alerts')? self::get('session_alerts') : [];
        $alerts[$type][] = $msg;
        self::set('session_alerts', $alerts);
        
    }

    // displays alerts
    public static function displaySessionAlerts() {
        $alerts = self::exists('session_alerts') ? self::get('session_alerts') : [];
        
        $html = "";
        
         foreach($alerts as $type => $msgs) {
            foreach($msgs as $msg) {
                $html .= "<div class='alert alert-dismissable alert-{$type}'>{$msg}<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";            }
        } 
        self::delete('session_alerts');
        return $html;
    }
}
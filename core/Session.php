<?php
namespace Core;
use Core\Request;

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
        if(self::exists('csrfToken') && self::get('csrfToken') == $check) {
            return true;
        }

        // Redirect page with no token
        Router::redirect('auth/badToken');
    }
}
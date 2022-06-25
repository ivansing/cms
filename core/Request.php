<?php
namespace Core;

class Request {

    // Post method
    public function isPost() {
        return $this->getRequestMethod() === 'POST';
    }

    // Put method
    public function isPut() {
        return $this->getRequestMethod() === 'PUT';
    }

    // Get method
    public function isGet() {
        return $this->getRequestMethod() === 'GET';
    }

    // Delete
    public function isDelete() {
        return $this->getRequestMethod() === 'DELETE';
    }

    // Path
    public function isPatch() {
        return $this->getRequestMethod() === 'PATCH';
    }

    public function getRequestMethod() {
        return strtoupper($_SERVER['REQUEST METHOD']);
    }

    public function get($input = false) {
        if(!$input) {
            $data = [];
            foreach($_REQUEST as $field => $value) {
                $data[$field] = self::sanitize($value);
            }
            return $data;
        }
        return array_key_exists($input, $_REQUEST)? self::sanitize($_REQUEST[$input]) : false;
    }

    // Formating html code 
    public static function sanitize($dirty) {
        return htmlentities(trim($dirty), ENT_QUOTES, "UTF-8");
    }
}
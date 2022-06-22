<?php

namespace Core;

use \PDO;
use \Exception;
use Core\{Config, Helpers};

class DB {
    protected $_dbh, $_results, $_lastInsertId, $_rowCount = 0, $_fetchType = PDO::FETCH_OBJ, $_class, $_error = false;
    protected $_stmt;
    protected static $_db;

    // Database connection
    public function __construct() {
        $host = Config::get('db_host');
        $name = Config::get('db_name');
        $user = Config::get('db_user');
        $pass = Config::get('db_password');
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false, 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];
        try{
            $this->_dbh = new PDO("mysql:host={$host};dbname={$name}", $user, $pass, $options);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    // Singleton pattern for various  connection  instances
    public static function getInstance(){
        if(!self::$_db){
            self::$_db = new self();
        }
        return self::$_db;
    }

    public function execute($sql, $bind=[]){
        $this->_results = null;
        $this->_lastInsertId = null;
        $this->_error = false;
        $this->_stmt = $this->_dbh->prepare($sql);
        if(!$this->_stmt->execute($bind)) {
            $this->_error = true;
        } else {
            $this->_lastInsertId = $this->_dbh->lastInsertId();
        }

        return $this;
    }

    public function query($sql, $bind=[]) {
        $this->execute($sql, $bind);
        if(!$this->_error) {
            $this->_rowCount = $this->_stmt->rowCount();
            $this->_results = $this->_stmt->fetchAll($this->_fetchType);
        }
        return $this;
    }

    public function results(){
        return $this->_results;
    }

    public function getCount() {
        return $this->_rowCount;
    }

    public function lastInsertId(){
        return $this->_lastInsertId;
    }
}
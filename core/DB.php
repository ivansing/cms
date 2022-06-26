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

    // ------- Getters ---------------
    
    public function query($sql, $bind=[]) {
        $this->execute($sql, $bind);
        if(!$this->_error) {
            $this->_rowCount = $this->_stmt->rowCount();
            if($this->_fetchType === PDO::FETCH_CLASS) {
                $this->_results = $this->_stmt->fetchAll($this->_fetchType, $this->_class);
            } else {
                $this->_results = $this->_stmt->fetchAll($this->_fetchType);
            }
            
        }
        return $this;
    }

    // Functions to insert values into the Database as INSERT INTO
    public function insert($table, $values) {
        $fields = [];
        $binds = [];
        foreach($values as $key => $value) {
            $fields[] = $key;
            $binds[] = ":{$key}";
        }
        $fielsStr = implode('`, `', $fields);
        $bindStr = implode(', ', $binds);
        $sql = "INSERT INTO {$table} (`{$fielsStr}`) VALUES ({$bindStr})";
        $this->execute($sql, $values);
        // If not error return true else false
        return !$this->_error;
    }

    // Update function to update value into db table
    public function update($table, $values, $conditions) {
        $binds = [];
        $valueStr = "";
        foreach($values as $field => $value) {
            $valueStr .= ", `{$field}` = :{$field}";
            $binds[$field] = $value;
        }
        $valueStr = ltrim($valueStr, ', ');
        $sql = "UPDATE {$table} SET {$valueStr}";

        // Concatenade conditional id 
        if(!empty($conditions)) {
            $conditionsStr = " WHERE ";
            foreach($conditions as $field => $value) {
                $conditionsStr .= "`{$field}` = :cond{$field} AND ";
                // Binds to avoid sql injection and shows as JSON format
                $binds['cond' .$field] = $value;
            }
            $conditionsStr = rtrim($conditionsStr, ' AND ');
            $sql .= $conditionsStr;
        }
        $this->execute($sql, $binds);
        return !$this->_error;
        
    }


    public function results(){
        return $this->_results;
    }

    public function count() {
        return $this->_rowCount;
    }

    public function lastInsertId(){
        return $this->_lastInsertId;
    }

    // ----------- For debugging purposes methods -------------
    public function getFetchType() {
        return $this->_fetchType;
    }

    public function getClass(){
        return $this->_class;
    }

    // ---------- Setters -----------
    public function setClass($class) {
        $this->_class = $class;
    }

    public function setFetchType($type) {
        $this->_fetchType = $type;
    }


}
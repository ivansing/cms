<?php
namespace Core;
use \PDO;
use \Core\{DB, Request};

class Model {
    protected static $table = "";
    protected static $columns = false;
    protected $_validationPassed = true, $_errors = [], $_skipUPdate = [];

    // Init db function
    protected static function getDb($setFetchClass = false) {
        $db = DB::getInstance();
        if($setFetchClass) {
            $db->setClass(get_called_class());
            $db->setFetchType(PDO::FETCH_CLASS);
        }
        /* Helpers::dnd(\PDO::FETCH_CLASS, false);
        Helpers::dnd($db->getClass());*/ 
        return $db;
    }

    // Insert method
    public static function insert($values) {
        $db = static::getDb();
        return $db->insert(static::$table, $values);
    }

    // Update method
    public static function update($values, $conditions) {
        $db = static::getDb();
        return $db->update(static::$table, $values, $conditions);
    }

    // Delete method
    public function delete() {
        $db = static::getDb();
        $table = static::$table;
        $params = [
            'conditions' => "id = :id",
            'bind' => ['id' => $this->id]
        ];
        list('sql' => $conds, 'bind' => $bind) = self::queryParamBuilder($params);
        $sql = "DELETE FROM {$table} {$conds}";
        return $db->execute($sql, $bind);
    }

    // Find method
    public static function find($params = []) {
        $db = static::getDb(true);
        list('sql' => $sql, 'bind' => $bind) = self::selectBuilder($params);
        return $db->query($sql, $bind)->results();
    }

    // Find the first element in the array
    public static function findFirst($params = []) {
        $db = static::getDb(true);
        list('sql' => $sql, 'bind' => $bind) = self::selectBuilder($params);
        $results = $db->query($sql, $bind)->results();
        return isset($results[0])? $results[0] : false;
    }

    // Find element by Id
    public static function findById($id) {
        return static::findFirst([
            'conditions' => "id = :id",
            'bind' => ['id' => $id]
        ]);
    }

    // Return the total rows as integer
    public static function findTotal($params = []) {
        unset($params['limit']);
        unset($params['offset']);
        $table = static::$table;
        $sql = "SELECT COUNT(*) AS total FROM {$table}";
        list('sql' => $conds, 'bind' => $bind) = self::queryParamBuilder($params);
        $sql .= $conds;
        $db = static::getDb();
        $results = $db->query($sql, $bind);
        $total = $results->getRowCount() > 0 ? $results->results()[0]->total : 0;
        return $total;
    }

    // Save smart method 
    public function save() {
        $save = false;
        $this->beforeSave();
        // Validation
        if($this->_validationPassed) {
            $db = static::getDb();
            $values = $this->getValuesForSave();
            if($this->isNew()) {
                $save = $db->insert(static::$table, $values);
                if($save) {
                    $this->id = $db->lastInsertId();
                }
            } else {
                $save = $db->update(static::$table, $values, ['id' => $this->id]);
            }
        }
        return $save;
    }

    // Helper function from save()
    public function isNew() {
        return empty($this->id);
    }

    // SELECT SQL builder 
    public static function selectBuilder($params = []) {
        $columns = array_key_exists('columns', $params)? $params['columns'] : "*";
        $table = static::$table;
        $sql = "SELECT {$columns} FROM {$table}";
        // To concatenate all of that list
        list('sql' => $conds, 'bind' => $bind) = self::queryParamBuilder($params);
        $sql .= $conds;
        return ['sql' => $sql, 'bind' => $bind];
    }

    // SQL  Builder conditions LIMIT, ORDER, JOIN WHERE clauses SQL
    public static function queryParamBuilder($params = []) {
        $sql = "";
        $bind = array_key_exists('bind', $params)? $params['bind'] : [];
       
        // joins
        // The result ----- [['table2', 'table1.id  = table2.key', 'tableAlias', 'LEFT']]
        if(array_key_exists('joins', $params)) {
            $joins = $params['joins'];
            foreach($joins as $join) {
                $joinTable = $join[0];
                $joinOn = $join[1];
                $joinAlias = isset($join[2])? $join[2] : "";
                $joinType = isset($join[3])? "{$join[3]} JOIN" : "JOIN";
                $sql .= " {$joinType} {$joinTable} {$joinAlias} ON {$joinOn}";
            }
        }
        // where
        if(array_key_exists('conditions', $params)) {
            $conds = $params['conditions'];
            $sql .= " WHERE {$conds}";
        }

        // group
        if(array_key_exists('group', $params)) {
            $group = $params['group'];
            $sql .= " GROUP BY {$group}";
        }

        // order
        if(array_key_exists('order', $params)) {
            $order = $params['order'];
            $sql .= " ORDER BY {$order}";
        }

        // limit
        if(array_key_exists('limit', $params)) {
            $limit = $params['limit'];
            $sql .= " LIMIT {$limit}";
        }

        // offset
        if(array_key_exists('offset', $params)) {
            $offset = $params['offset'];
            $sql .= " OFFSET {$offset}";
        }
        return ['sql' => $sql, 'bind' => $bind];
    }

    public function getValuesForSave() {
        $columns = static::getColumns();
        $values = [];
        foreach($columns as $column) {
            // _skipUpdate it is a empty array
            if(!in_array($column, $this->_skipUPdate)) {
                $values[$column] = $this->{$column};
            }
        }
        return $values;
    }

    // Get columns for first time as a singleton pattern unique
    public static function getColumns(){
        if(!static::$columns) {
            $db = static::getDb();
            $table = static::$table;
            $sql = "SHOW COLUMNS FROM {$table}";
            $results = $db->query($sql)->results();
            $columns = [];
            foreach($results as $column) {
                $columns[] = $column->Field;
            }
            static::$columns = $columns;
        }
        return static::$columns;
    }

    

    // Form validator method from abstract class Validator
    public function runValidation($validator) {
        $validates = $validator->runValidation();
        if(!$validates) {
            $this->_validationPassed = false;
            $this->_errors[$validator->field] = $validator->msg;
        }
    }

    // Get Errors messages

    public function getErrors() {
        return $this->_errors;
    }

    public function setError($name, $value) {
        $this->_errors[$name] = $value;
    }

    // Timestamp for time creation column
    public function timeStamps() {
        $dt = new \DateTime("now", new \DateTimeZone("UTC"));
        $now = $dt->format('Y-m-d H:i:s');
        $this->updated_at = $now;
        if($this->isNew()) {
            $this->created_at = $now;
        }
    }

    // Set pagination
    public static function mergeWithPagination($params = []) {
        $request = new Request();
        $page = $request->get('p');
        if(!$page || $page < 1) $page = 1;
        $limit = $request->get('limit') ? $request->get('limit') : 25;
        $offset = ($page - 1) * $limit;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        return $params;
    }

    public function beforeSave(){}
}
<?php
namespace Core\Validators;
use Core\Validators\Validator;
use Core\Helpers;

class UniqueValidator extends Validator {

    // Check if email address is unique in the db
    public function runValidation(){
        // obj is the user class
        $value = $this->_obj->{$this->field};
        if($value == '' || !isset($value)) {
            return true;
        }

        

        $conditions = "{$this->field} = :{$this->field}";
        $bind = [$this->field => $value];

        // Check update record it s a new match and id is not equal to the current id 
        if(!$this->_obj->isNew()) {
            $conditions .= " AND id != :id";
            $bind['id'] = $this->_obj->id;
        }

        // Check multiple fields for unique ones
        foreach($this->additionalFieldData as $adds) {
            $conditions .= " AND {$adds} = : {$adds}";
            $bind[$adds] = $this->_obj->{$adds};
        }

        // Check if obj exists
        $queryParams = ['conditions' => $conditions, 'bind' => $bind];
        Helpers::dnd($queryParams);
        $exists = $this->_obj::findFirst($queryParams);
        
        return !$exists;

    }
}
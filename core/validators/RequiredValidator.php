<?php
namespace Core\Validators;
use Core\Validators\Validator;

class RequiredValidator extends Validator {
    
    // Required abstract method return true or false
    public function runValidation(){
        $value = trim($this->_obj->{$this->field});
        $passes = $value != '' && isset($value);
        return $passes;
    }
}
<?php
namespace Core\Validators;
use Core\Validators\Validator;

class NumericValidator extends Validator {
    public function runValidation() {
        // Pass field on the Users class
        $value = $this->_obj->{$this->field};
        $pass = true;
        // If not empty we will check it if numeric bool type
        if(!empty($value)) {
            $pass = is_numeric($value);
        }
        return $pass;
    }
}
<?php
namespace Core\Validators;
use Core\Validators\Validator;

class MinValidator extends Validator {
    public function runValidation() {
        $value = $this->_obj->{$this->field};
        $pass = strlen($value) >= $this->rule;
        return $pass;
    }
}
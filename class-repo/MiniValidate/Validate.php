<?php

/**
 * PHP Simple Validation Class
 * v.1.0
 * @author Tommy Vercety
 */
class Validate {
    
    /**
     * Boolean value,l that holds if the
     * test has finished successfully or not.
     * 
     * @var boolean
     */
    private $_passed = FALSE;
    
    /**
     * Error array, that holds all text for
     * errors that occur during the validation.
     * 
     * @var array
     */
    private $_errors = array();
    
    /**
     * Push to error array.
     * 
     * @param string $error
     */
    private function addError($error) {
        $this->_errors[] = $error;
    }
            
    public function __construct() {}
    
    /**
     * Main validation method, check provided 
     * array to a given array with rules.
     * 
     * @param  array  $source the array with data that needs to be verified
     * @param  array  $items  the array with rules to verify on
     * @return object         class instance
     */
    public function check($source, $items = array()) {
        
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                
                $item  = trim($item);
                $value = trim($source[$item]);
                
                if ($rule === 'required' && empty($value)) { $this->addError("{$item} is required."); }
                else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                            
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                            
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}.");
                            }
                            break;
                            
                        case 'alphanumeric':
                            if (preg_match('/[^a-zA-Z0-9]+/', $value)) {
                                $this->addError("{$item} must contain only alpha-numeric characters.");
                            }
                            break;
                            
                        case 'alpha':
                            if (preg_match('/[^a-zA-Z]+/', $value)) {
                                $this->addError("{$item} must contain only alphabetic characters.");
                            }
                            break;
                            
                        case 'numeric':
                            if (preg_match('/[^0-9]+/', $value)) {
                                $this->addError("{$item} must contain only numeric characters.");
                            }
                            break;
                            
                        case 'alpha_dash':
                            if (preg_match('/[^a-zA-Z0-9_\-]+/', $value)) {
                                $this->addError("{$item} must contain only alpha-numeric characters, underscores & dashes.");
                            }
                            break;
                            
                        case 'valid_email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("{$item} is not a valid email.");
                            }
                            break;
                    }
                }
            }
        }
        
        if (empty($this->_errors)) {
            $this->_passed = TRUE;
        }
        return $this;
    }
    
    /**
     * Get errors array
     * @return array
     */
    public function errors() {
        return $this->_errors;
    }
    
    /**
     * Check if validation has passed
     * @return boolean
     */
    public function passed() {
        return $this->_passed;
    }
}

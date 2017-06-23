<?php


namespace MVC;


/**
 * Class Validation
 * @package MVC
 */
class Validation
{
    private static $_instance = null;
    /**
     * @var array
     * will hold the rule lis
     */
    private $_rules = [];
    /**
     * @var array
     * will hold the output errors
     */
    private $_errors = [];
    public static function getInstance():Validation{
        if (self::$_instance == null) {
            self::$_instance = new Validation();
        }
        return self::$_instance;
    }

    /**
     * @param string $ruleName
     * @param string $data
     * @param string|null $param
     * @param string|null $errorBack
     * @return $this
     */
    public function setRule(string $ruleName, string $data, string $param = null, string $errorBack = null){
        $this->_rules[] = ["data"       => $data,
                            "ruleName"  => $ruleName,
                            "param"     => $param,
                            "error"  => $errorBack
                          ] ;
        return $this;
    }

    /**
     * validates rules
     * @return bool
     */
    public function validate(){
        $this->_errors = []; // reset the error array
        if (count($this->_rules) > 0) {
            foreach ($this->_rules as $rule) {

                $ruleName = $rule['ruleName'];
                $ruleData = $rule['data'];
                $ruleParam = $rule['param'];
                if (!$this->$ruleName ($ruleData,$ruleParam)) {
                    if ($rule['error']) {
                        $this->_errors[] = $rule['error'];
                    } else {
                        $this->_errors[] = $rule['ruleName'];
                    }
                }
            }
        }
        if (count($this->_errors)) {
            return false;
        }
        return true;
    }
    
    public function getErrors(){
        return $this->_errors;
    }


    /**
     * evaluate if param 1 == param 2
     * @return bool
     */
    public static function matches($val1, $val2) {
        return $val1 == $val2;
    }

    /**
     * @param $param
     * @param $len
     * @return bool
     * evaluate if param1 is bigger or equal to len
     */
    public static function minlength($param, $len){
        return (mb_strlen($param) >= $len);
    }

    public static function maxlength($param, $len){
        return (mb_strlen($param) <= $len);
    }

    public static function required($val) {
        if (is_array($val)) {
            return !empty($val);
        } else {
            return $val != '';
        }
    }

    public static function matchesStrict($val1, $val2) {
        return $val1 === $val2;
    }

    public static function different($val1, $val2) {
        return $val1 != $val2;
    }

    public static function differentStrict($val1, $val2) {
        return $val1 !== $val2;
    }

    public static function exactlength($val1, $val2) {
        return (mb_strlen($val1) == $val2);
    }

    public static function gt($val1, $val2) {
        return ($val1 > $val2);
    }

    public static function lt($val1, $val2) {
        return ($val1 < $val2);
    }

    public static function alpha($val1) {
        return (bool) preg_match('/^([a-z])+$/i', $val1);
    }

    public static function alphanum($val1) {
        return (bool) preg_match('/^([a-z0-9])+$/i', $val1);
    }

    public static function alphanumdash($val1) {
        return (bool) preg_match('/^([-a-z0-9_-])+$/i', $val1);
    }

    public static function numeric($val1) {
        return is_numeric($val1);
    }

    public static function email($val1) {
        return filter_var($val1, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function emails($val1) {
        if (is_array($val1)) {
            foreach ($val1 as $v) {
                if (!self::email($val1)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public static function url($val1) {
        return filter_var($val1, FILTER_VALIDATE_URL) !== false;
    }

    public static function ip($val1) {
        return filter_var($val1, FILTER_VALIDATE_IP) !== false;
    }

    public static function regexp($val1, $val2) {
        return (bool) preg_match($val2, $val1);
    }

    public static function custom($val1, $val2) {
        if ($val2 instanceof \Closure) {
            return (boolean) call_user_func($val2, $val1);
        } else {
            throw new \Exception('Invalid validation function');
        }
    }

    public function __call($name, $arguments)
    {
        throw new \Exception("ERROR: Validation rule does not exist -> {$name}");
    }
}
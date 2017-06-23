<?php


namespace MVC;


class GlobalVariables
{
    private static $_instance = null;

    private $globalVariables = [];
    /**
     * GlobalVariables constructor.
     */
    private function __construct()  {   }

    /**
     * returns the current instance of app.. or if there is not any .. it will create new instance and return it !
     * @return GlobalVariables
     */

    public static function getInstance():GlobalVariables{
        if (self::$_instance == null) {
            self::$_instance = new GlobalVariables();
        }
        return self::$_instance;
    }

    public function setGlobalVar(string $name, $globalVar){
        if (isset($name)) {
            $this->globalVariables[$name] = $globalVar;
        }
    }

    public function getGlobalVar(string $name){
        if (isset($this->globalVariables[$name])) {
            return $this->globalVariables[$name];
        }
    }

    public function getAllGlobalVar():array {
        return $this->globalVariables;
    }
}
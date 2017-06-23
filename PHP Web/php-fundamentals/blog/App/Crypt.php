<?php


namespace MVC;


/**
 * Class Crypt
 * @package MVC
 */
/**
 * Class Crypt
 * @package MVC
 */
class Crypt
{
    /**
     * @var Crypt
     * holds instance of itself
     */
    private static $_instance = null;

    /**
     * Crypt constructor.
     */
    private function __construct()   { } // make it proper singleton

    /**
     * @return Crypt
     */
    public static function getInstance():Crypt{
        if (self::$_instance == null) {
            self::$_instance = new Crypt();
        }
        return self::$_instance;
    }

    public function getUniqeId(bool $longId = true){
        return uniqid("",$longId);
    }

    /**
     * @return string
     * it returns Salt for Hashing
     */
    public function getNewSalt(){
        return md5($this->getUniqeId());
    }

    /**
     * @param string $password
     * @param string|null $salt
     * @param int|null $cost
     * @return bool|string
     * it returns hashed string/password
     */
    public function getHash(string $password, string $salt = null , int $cost = null){
        $options = [];
        if ($cost !== null) {
            $options["cost"] = $cost;
        }
        if ($salt !== null) {
            $options["salt"] = $salt;
        }
        $hash = $this->BCRYPT($password, $options);
        return $hash;
    }

    /**
     * @param string $password
     * @param array $options
     * @return bool|string
     * bicript hashing algorithm
     */
    private function BCRYPT(string $password, array $options = []){
       return password_hash($password, PASSWORD_BCRYPT, $options);
    }

}
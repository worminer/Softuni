<?php


namespace MVC;


use MVC\Database\PdoMysql;

/**
 * Class Auth
 * @package MVC
 * authentication logic
 */
class Auth extends PdoMysql
{
    /**
     * @var null
     */
    private static $_instance = null;
    
    private $_session = null;

    private $currentUserID = null;

    private $userRoles = [];


    /**
     * @var Crypt
     * holds an instance of Crypt
     */
    public $crypt;
    public $errorMessage;

    /**
     * Auth constructor.
     */
    public function __construct()    {
        parent::__construct();
        $this->isValidSessionToken();
        $global = GlobalVariables::getInstance();
        $global->setGlobalVar("isLogged",$this->isLogged());
        $global->setGlobalVar("isUser",$this->isInRole('user'));
        $global->setGlobalVar("isAdmin",$this->isInRole('admin'));
    }


    /**
     * @return Auth
     */
    public static function getInstance():Auth{
        if (self::$_instance == null) {
            self::$_instance = new Auth();
        }
        return self::$_instance;
    }

    /**
     * @param string $username
     * @return bool
     * well check if username exist in DB
     */
    public function userExist(string $username):bool{
        // in prepare you have to put "sql query with ? for placeholder", [array of values for the placeholder]
        // we don't use SELECT * because we dont need all the info..
        // instead we get only the id..
        //  and that makes the query way faster then if we use SELECT *
        $result = $this->prepare("SELECT id FROM users WHERE username=?",[$username]) // make a prepared statement
        ->execute(); // and after that this needs to be executed so you can receive the result if there is any
        // after that we need to get the results from the PDO return so we do fetchRllAssoc() ..
        // this will return the fist result or false if there are no results
        $result = $result->fetchRllAssoc();

        // if there are no result, we return false
        if ($result === false) {
            return false;
        }
        // if there is an result, return true
        return true;
    }



    public function isValidSessionToken(){
        // if there is no session token .. session is not valid so return false

        if ($this->getSession()->AuthToken === null) {
            return false;
        }
        if ($this->currentUserID !== null) {
            return true;
        }
        $sessionToken = $this->getSession()->AuthToken;
        $result = $this ->prepare("SELECT id,session_token_expire FROM users WHERE session_token=?",[$sessionToken])->execute();
        //if there is no such token in the user table .. session is not valid.. so return false
        if ($result === false) {
            return false;
        }

        $result = $result->fetchRllAssoc(); // getting the result

        // if expiration time is bigger then current time.. session expired .. soo return false
        if ($result['session_token_expire'] < time()) {
            return false;
        }

        // if we are here in code that means that everything is ok and we can save the user and update the time
        $this->setCurrentUserId($result['id']);

        // and we extend the lifetime of the users token
        if ($this->renewSessionLifeTime($sessionToken)) {
            return false;
        }

        return true;
    }

    private function renewSessionLifeTime($sessionToken){
        $session = $this->getSession();
        $lifeTime = time() + $session->getLifeTime();
        $session->AuthToken = $sessionToken;

        $result = $this->prepare("UPDATE `users` SET `session_token_expire`=? WHERE session_token=?",
            [$lifeTime,$sessionToken])->execute();
        $this->getSession()->AuthToken = $sessionToken;
        return (bool) $result->getAffectedRows();
    }

    private function setCurrentUserId(int $id){
        $this->currentUserID = $id;
    }

    public function getCurrentUserId(){
        if ($this->currentUserID === null) {
            $this->isValidSessionToken();
        }
        return $this->currentUserID;
    }

    public function isLogged():bool{
        if ($this->getCurrentUserId() == null) {
            return false;
        }
        return true;
    }
    
    public function getRoles(){
        if (count($this->userRoles) == 0) {
            $result = $this->prepare('Select role_name FROM user_roles AS ur Join roles AS r ON ur.role_id=r.id WHERE ur.user_id=?', [$this->getCurrentUserId()])->execute();
            $result = $result->fetchAllAssoc();
            if (count($result) > 0) {
                foreach ($result as $resultArr){
                    $this->userRoles[] =$resultArr["role_name"] ;
                }
            }
        }
        return $this->userRoles;
    }

    public function isInRole(string $role){
        return in_array($role,$this->getRoles());
    }

    public function logOut(){
        $this->getSession()->AuthToken = '';
    }

    public function getErrorMessage(){
        return $this->errorMessage;
    }


    private function getCrypt() {
        if ($this->crypt === null) {
            $this->crypt    = \MVC\Crypt::getInstance();
        }
        return $this->crypt;
    }

    public function getSession() {
        if ($this->_session === null) {
            $this->_session    = \MVC\App::getInstance()->getSession();
        }
        return $this->_session;
    }
}
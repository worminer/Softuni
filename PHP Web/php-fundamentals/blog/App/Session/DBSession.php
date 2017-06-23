<?php


namespace MVC\Session;


class DBSession extends \MVC\Database\PdoMysql  implements SessionInterface
{
    /**
     * @var string
     */
    private $sessionName;
    /**
     * @var string
     */
    private $tableName;
    /**
     * @var int
     */
    private $lifetime;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $domain;
    /**
     * @var bool
     */
    private $secure;
    /**
     * @var string
     */
    private $sessionId = null;
    /**
     * @var array
     */
    private $sessionData= [];
    private $dbConnection = null;

    /**
     * DBSession constructor.
     * @param string|null $dbconnection
     * @param string $sessionName
     * @param string $tableName
     * @param int $lifetime
     * @param string|null $path
     * @param string|null $domain
     * @param bool $secure
     */
    public function __construct($dbconnection,
                                string $sessionName,
                                string $tableName = "session",
                                int $lifetime = 3600,
                                string $path = null,
                                string $domain = null,
                                bool $secure = false)
    {
        $this->dbConnection = parent::__construct($dbconnection);

        $this->sessionName = $sessionName;
        $this->tableName = $tableName;
        $this->lifetime = $lifetime;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        if (isset($_COOKIE[$sessionName])) {
            $this->sessionId = $_COOKIE[$sessionName];
        }
        // pseudo garbage collector call at 1/50 chance to run .. so it can clean old session records
        if (rand(0,50) == 1) {
            $this->_garbageCollector();
        }
        if (strlen($this->sessionId) < 32) { // not valid session id
            $this->_startNewSession();
        } else if ( !$this->validateSession()) { // validate session
            $this->_startNewSession();
        }
    }

    private function validateSession(){
        if (isset($this->sessionId)) {
            $result = $this->prepare('SELECT * FROM ' . $this->tableName . ' WHERE sessid=? and valid_untill<=?', array($this->sessionId,(time() + $this->lifetime)))->execute();
            $result = $result->fetchAllAssoc();
            if (is_array($result) && count($result) == 1 && isset($result[0])) {
                $this->sessionData = unserialize($result[0]["sess_data"]);
                return true;
            }
        }
        return false;
    }

    private function _startNewSession(){

        $this->sessionId = md5(uniqid("gf",true)); //createArticle unique 23 symbol number and hash it to 32 symbols so we have 32 unique session id

        $this->prepare("INSERT INTO {$this->tableName} (sessid,valid_untill) VALUES (?,?)",[$this->sessionId,(time() + $this->lifetime)])->execute();
        setcookie($this->sessionName,$this->sessionId,(time() + $this->lifetime),$this->path,$this->domain,(bool)$this->secure,true);
    }

    /**
     *
     */
    public function getSessionId()
    {
       return $this->sessionId;
    }

    /**
     *
     */
    public function saveSession()
    {
        $this->prepare("UPDATE {$this->tableName} SET sess_data=?,valid_untill=? WHERE sessid=?",[serialize($this->sessionData),(time() + $this->lifetime),$this->sessionId])->execute();
        setcookie($this->sessionName,$this->sessionId,(time() + $this->lifetime),$this->path,$this->domain,(bool)$this->secure,true);
    }

    /**
     *
     */
    public function destroySession()
    {
        if (isset($this->sessionId)) {
            $this->prepare("DELETE FROM {$this->tableName} WHERE sessid=?",[$this->sessionId])->execute();
        }
    }


    public function __get($name)
    {
        if (isset($this->sessionData[$name])) {
            return $this->sessionData[$name];
        }
    }

    public function __set($name, $value)
    {
       $this->sessionData[$name] = $value;
    }
    public function _garbageCollector(){
        $this->prepare("DELETE FROM {$this->tableName} WHERE valind_untill<?", [time()])->execute();
    }

    public function getLifeTime()
    {
        return $this->lifetime;
    }
}
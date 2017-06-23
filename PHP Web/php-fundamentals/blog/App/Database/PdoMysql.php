<?php


/**
 * Class PdoMysql
 */
namespace MVC\Database;

class PdoMysql
{
    /**
     * @var string
     */
    private $connectionName = 'default' ;
    /**
     * @var PDO
     */
    private $db = null;
    /**
     * @var \PDOStatement
     */
    private $stmt = null;
    /**
     * @var array
     */
    private $params = [];
    /**
     * @var string
     */
    private $sql = null;

    /**
     * PdoMysql constructor.
     * @param  $connection
     */
    public function __construct($connection = null)
    {
        if ($connection instanceof \PDO) {
            $this->connectionName = $connection;
        } else if($connection != null) {
            $this->connectionName = $connection;
            $this->db = \MVC\App::getInstance()->getDbConnection($connection);
        } else {
            $this->db = \MVC\App::getInstance()->getDbConnection($this->connectionName);
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @param array $pdoOptions
     * @return PdoMysql $this
     */
    public function prepare(string $sql, array $params = [], array $pdoOptions = []) {
        $this->stmt = $this->db->prepare($sql,$pdoOptions);
        $this->params = $params;
        $this->sql = $sql;
        return $this;
    }

    /**
     * @param array $params
     * @return PdoMysql $this
     */
    public function execute(array $params = []) {
        if ($params) {
            $this->params = $params;
        }
        $this->stmt->execute($this->params);
        return $this;
    }

    public function fetchAllAssoc(){
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function fetchRllAssoc(){
        return $this->stmt->fetch   (\PDO::FETCH_ASSOC);
    }

    public function fetchAllNum(){
        return $this->stmt->fetchAll(\PDO::FETCH_NUM);
    }
    public function fetchRawNum(){
        return $this->stmt->fetch   (\PDO::FETCH_NUM);
    }

    public function fetchAllObj(){
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    public function fetchRawObj(){
        return $this->stmt->fetch   (\PDO::FETCH_OBJ);
    }

    public function fetchAllColumn($column){
        return $this->stmt->fetchAll(\PDO::FETCH_COLUMN,$column);
    }
    public function fetchRawColumn($column){
        return $this->stmt->fetch   (\PDO::FETCH_BOUND,$column);
    }

    public function fetchAllClass($class){
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS,$class);
    }
    public function fetchRawClass($class){
        return $this->stmt->fetch   (\PDO::FETCH_BOUND,$class);
    }

    public function getLastInsertId(){
        return $this->db->lastInsertId();
    }
    public function getAffectedRows(){
        return $this->stmt->rowCount();
    }
    public function getSTMT(){
        return $this->stmt;
    }

}
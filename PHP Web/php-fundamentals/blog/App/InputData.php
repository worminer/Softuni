<?php


namespace MVC;


class InputData
{
    /**
     * @var null
     */
    private static  $_instance = null;
    /**
     * @var array
     * will hold $_GET params
     */
    private $_get = array();
    /**
     * @var array
     * will hold $_POST params
     */
    private $_post = array();

    private $_file = [];
    /**
     * @var array
     * will hold $_COOKIE params
     */
    private $_cookies = array();

    /**
     * InputData constructor.
     */
    private function __construct()
    {
        $this->_cookies = $_COOKIE;
    }

    /**
     * @return InputData
     */
    public static function getInstance():InputData{
        if (self::$_instance == null) {
            self::$_instance = new InputData();
        }
        return self::$_instance;
    }

    /**
     * @param array $get
     */
    public function setGet(array $get)
    {
        if (is_array($get)) {
            $this->_get = $get;
        }
    }

    public function get($id, $normalize = null, $default = null){
        if (!$this->hasGet($id)) {
            return $default;
        }
        if ($normalize != null) {
            return Utill::normalize($this->_get[$id],$normalize);
        }
        return $this->_get[$id];
    }

    public function post($name, $normalize = null, $default = null){
        if (!$this->hasPost($name)) {
            return $default;
        }
        if ($normalize != null) {
            return Utill::normalize($this->_post[$name],$normalize);
        }
        return $this->_post[$name];
    }

    public function file($name, $default = null){
        if (!$this->hasFile($name)) {
            return $default;
        }

        return $this->_file[$name];
    }

    public function cookie($name, $normalize = null, $default = null){
        if (!$this->hasCookie($name)) {
            return $default;
        }
        if ($normalize != null) {
            return Utill::normalize($this->_cookies[$name],$normalize);
        }
        return $this->_cookies[$name];
    }
    /**
     * @param array $post
     */
    public function setPost(array $post)
    {
        if (is_array($post)) {
            $this->_post = $post;
        }
    }
    public function getFile()
    {
       return $this->_file;
    }
    public function setFile(array $file)
    {
        if (is_array($file)) {
            $this->_file = $file;
        }
    }

    public function hasGet($id){
        return array_key_exists($id, $this->_get);
    }

    public function hasPost(string $name){
        return array_key_exists($name,$this->_post);
    }
    public function hasFile(string $name){
        return array_key_exists($name,$this->_file);
    }

    public function hasCookie(string $name){
        return array_key_exists($name,$this->_cookies);
    }
}
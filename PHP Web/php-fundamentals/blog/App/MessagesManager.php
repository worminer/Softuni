<?php


namespace MVC;

class MessagesManager
{
    private static $_instance = null;
    private $_session = null;
    private $messages = [];
    private $messageTypes = ["success", "error", "warning"];

    /**
     * MessagesManager constructor.
     */
    private function __construct(){
        $this->_session = App::getInstance()->getSession();
        $messages = unserialize($this->_session->MessageManager);
        if (is_array($messages)) {
            $this->messages = $messages;
        }


    }

    public static function getInstance():MessagesManager{
        if (self::$_instance == null) {
            self::$_instance = new MessagesManager();
        }
        return self::$_instance;
    }

    public function setMessage(string $type , $messages){

        if ($type === null) {
            throw new \Exception("Error:MessageManager setMessage -> type can not be empty!");
        }
        if ($messages === null) {
            throw new \Exception("Error:MessageManager setMessage -> message can not be empty!");
        }
        $type = strtolower($type);
        if (!in_array($type, $this->messageTypes)) {
            throw new \Exception("Error: MessageManager setMessage -> Unknown type of '{$type}'!");
        }

        if (is_array($messages)) {

            if (!array_key_exists($type,$this->messages)) {
                $this->messages[$type] = [];
            }
            $this->messages[$type] = array_merge($this->messages[$type],$messages);
        } else {
            $this->messages[$type][] = $messages;
        }
        $this->saveMessages();
        
    }

    public function getMessages(string $type){
        if ($type === null) {
            throw new \Exception("Error:MessageManager setMessage -> type can not be empty!");
        }
        $type = strtolower($type);
        if (!in_array($type, $this->messageTypes)) {
            throw new \Exception("Error: MessageManager setMessage -> Unknown type of '{$type}'!");
        }
        return $this->messages[$type];
    }

    public function getAllMessages():array {
        return $this->messages;
    }

    public function flushAllMessages(){
        $this->messages = [];
        $this->saveMessages();
    }

    public function saveMessages(){
        $this->_session->MessageManager = serialize($this->messages);

    }

}
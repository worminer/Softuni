<?php


namespace MVC\Session;


interface SessionInterface
{
    /**
     * @return mixed
     * wull return session id
     */
    public function getSessionId();
    public function saveSession();
    public function destroySession();
    public function getLifeTime();
    public function __get($name);
    public function __set($name,$value);

}
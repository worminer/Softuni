<?php


namespace MVC\Routers;



interface RouterInterface
{
    /**
     * returns URI of type /controller/action/param1/param2
     */
    public function getURI();
    /**
     *
     * and sets controller,action and params from URI
     */
    public function parse();
    /**
     * @return string
     */
    public function getController();
    /**
     * @return string
     */
    public function getAction();
    /**
     * @return array
     */
    public function getGetParams();
    /**
     * @return string
     */
    public function getControllerNamespace();

    /**
     * @return mixed
     * ill return post params
     */
    public function getPost();

    public function getFile();
}
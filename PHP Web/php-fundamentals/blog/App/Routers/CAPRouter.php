<?php


namespace MVC\Routers;


use MVC\Utill;

class CAPRouter implements RouterInterface
{

    /**
     * @var string
     */
    private $controller = null;
    /**
     * @var static
     */
    private $action = null;
    /**
     * @var array
     */
    private $params = [];

    private $postData = [];

    private $fileData = [];
    /**
     * returns URI
     * @return string
     */
    public function getURI(){
        return Utill::getCleanLinkURI();
    }
    /**
     * parses url of type website.com/controller/action/param1/param2
     * and sets controller,action and params
     */
    public function parse(){
        $urlParams = $this->getURI();

        $urlParams = explode("/",$urlParams);
        $controller = null;
        $action = null;
        if (isset($urlParams[0]) && !empty(trim($urlParams[0]))) {
            $this->controller = strtolower(array_splice($urlParams,0,1)[0]);
        }

        if (isset($urlParams[0]) && !empty(trim($urlParams[0]))) {
            $this->action = strtolower(array_splice($urlParams,0,1)[0]);
        }
        $this->params = $urlParams;
        $this->postData = $_POST;
        $this->fileData = $_FILES;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return strtolower($this->controller);
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return strtolower($this->action);
    }

    /**
     * @return array
     */
    public function getGetParams()
    {
        return $this->params;
    }

    /**
     *
     * returns the namespace .. but in this case we return null so we can get the default namespace ..
     * because we don't have mechanics to get namespace from this parser..
     */
    public function getControllerNamespace()
    {
        return null;
    }

    public function getPost()
    {
       return $this->postData;
    }

    public function getFile()
    {
        return $this->fileData;
    }
}
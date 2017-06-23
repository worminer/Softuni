<?php

namespace MVC\Routers;

use MVC\Config;

/**
 * Class CleanLinkRouter
 * @package MVC\Routers
 * will parse url's of type clearLink..
 * aka website.com/controller/action/param1/param2
 */
class CleanLinkRouter implements RouterInterface
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
     * @var string
     */
    private $params = null;

    /**
     * returns URI
     * @return string
     */
    public function getURI()
    {
        return substr($_SERVER["PHP_SELF"],strlen($_SERVER["SCRIPT_NAME"])+1);
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
            $this->controller = ucfirst(array_splice($urlParams,0,1)[0]);
        }

        if (isset($urlParams[0]) && !empty(trim($urlParams[0]))) {
            $this->action = ucfirst(array_splice($urlParams,0,1)[0]);
        }
        $this->params = $urlParams;
    }

    /**
     * @return string
     */
    public function getController()
    {
       return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getGetParams()
    {
        $this->params;
    }

    public function getControllerNamespace()
    {
        return null;
    }

    public function getPost()
    {
        // TODO: Implement getPost() method.
    }
}
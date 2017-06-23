<?php


namespace MVC;
use MVC\Routers\RouterInterface;


/**
 * Class FrontController
 * @package MVC
 */
class FrontController
{

    /**
     * @var Config
     */
    private $_config = null;
    /**
     * @var FrontController
     * will hold the instance of FrontController for singleton
     */
    private static $_instance = null;
    /**
     * @var null
     * will hold the name of the router
     */
    private $routerSettings = null;

    /**
     * FrontController constructor.
     * its private because its singleton
     */
    private function __construct()
    {
        $this->_config = Config::getInstance();
    }

    /**
     * @return FrontController
     */
    public static function getInstance():FrontController{
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }
        return self::$_instance;
    }

    public function dispatcher(){

        $routerSettings = $this->getRouterSettings();

        $routerToLoad =$routerSettings['namespace']."\\".$routerSettings['name'];
        /**
         * @var RouterInterface $router
         */
        $router = new $routerToLoad();
        $router->parse();
        // setting up controller

        $controller = ucfirst($router->getController());

        if ($controller == null) {
            $controller = ucfirst($this->getDefaultController());
        }

        // setting up action(method)
        $action     = ucfirst($router->getAction());
        if ($action == null) {
            $action = ucfirst($this->getDefaultAction());
        }

        // putting get and post in input data manager
        $inputData = \MVC\InputData::getInstance();
        $inputData->setGet($router->getGetParams());
        $inputData->setPost($router->getPost());
        $inputData->setFile($router->getFile());

        $namespace  = $router->getControllerNamespace();
        if ($namespace == null) {
            $namespace = $this->getDefaultNamespace();
        }


        $controllerToCall = $namespace."\\".$controller;
        //echo $controllerToCall."<br>";
        //echo $controller."->".$action."<br>";
        $currentController = new $controllerToCall();

        $currentController->$action();
    }

    public function getDefaultController(){
        if (isset($this->_config->routers["DefaultController"]) && strlen(trim($this->_config->routers["DefaultController"])) > 0) {
           return strtolower($this->_config->routers["DefaultController"]);
        } else {
           return strtolower("Index");
        }
    }

    public function getDefaultAction(){
        if (isset($this->_config->routers["DefaultAction"]) && strlen(trim($this->_config->routers["DefaultAction"])) > 0) {
            return strtolower($this->_config->routers["DefaultAction"]);
        } else {
            return strtolower("Index");
        }
    }

    public  function getDefaultNamespace(){

        if (isset($this->_config->routers["DefaultControllerNamespace"]) && strlen(trim($this->_config->routers["DefaultControllerNamespace"])) > 0) {

            return ($this->_config->routers["DefaultControllerNamespace"]);
        } else {
            //TODO: change namespace to something usefull after tesing
            return "controllers";
        }
    }

    public function setRouterSettings(string $routerName){
        if (isset($this->_config->routers["Routers"][$routerName])) {
            $this->routerSettings = $this->_config->routers["Routers"][$routerName];
        } else {
            throw new \Exception("ERROR: Router that you want to set does not exist in the routers Config - {$routerName}");
        }

    }
    public function getRouterSettings():array {
        if (!is_array($this->routerSettings)) {
            throw new \Exception("ERROR: Router Array is not set!");
        }
        return $this->routerSettings;
    }

}
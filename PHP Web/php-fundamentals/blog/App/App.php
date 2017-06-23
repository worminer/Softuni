<?php
namespace MVC;

use MVC\Session\SessionInterface;
require_once("AutoLoader.php");


class App {
    /**
     * will use singleton style logic because we will need only one instance of App..
     * so this will hold the instance of App
     * @var App
     */
    private static $_instance = null;

    /**
     * @var Config
     * will hold instance of config
     */
    private $_config = null;

    /**
     * @var FrontController
     * will hold the FrontController instance.
     */
    private $_frontController = null;
    /**
     * @var array
     * will hold database connections
     */
    private $_DbConnections = [];
    /**
     * @var SessionInterface
     * will hold session obj
     */
    private $_session = null;

    /**
     * @var Validation
     * will hold getValidator object
     */
    private $_validator = null;
    /**
     * @var InputData
     * will hold input data object
     */
    private $_inputData = null;

    /**
     * @var View
     */
    private $_view = null;

    /**
     * @var Auth
     */
    private $_auth = null;

    /**
     * @var GlobalVariables $_globals
     */
    private $_globals = null;

    /**
     * @var
     */
    private $applicationStartedTimer = null;

    /**
     * App constructor.
     */
    private function __construct()
    {
        //set_exception_handler([$this, "_exceptionHandler"]);
        // registering namespace MVC
        AutoLoader::registerNamespace("MVC", dirname(__FILE__));
        // register the autoload function that will be called when file is needed..
        AutoLoader::registerAutoLoad();
        //get instance of config
        $this->_config = Config::getInstance();
    }

    /**
     * returns the current instance of app.. or if there is not any .. it will createArticle new instance and return it !
     * @return App
     */
    public static function getInstance():App{
        if (self::$_instance == null) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * @throws \Exception
     */
    public function run(){
        // if there is no config folder set..sets the default one
        if ($this->_config->getConfigFolderPath() == null) {
            $this->_config->setConfigFolder("../config");
        }

        // debuging timert
        if ($this->_config->app["debugging"]) {
            $this->applicationStartedTimer = microtime(true);
        }

        //setting global variables
        $global = $this->getGlobals();
        if (isset($this->_config->app['site_title'])) {
            $global->setGlobalVar("site_title",$this->_config->app['site_title']);
        }

        //have to get an instance of the FrontController
        $this->_frontController = FrontController::getInstance();

        // setting default router
        if (isset($this->_config->routers["DefaultRouter"])) {
            $defaultRouter = $this->_config->routers["DefaultRouter"];
            $this->_frontController->setRouterSettings($defaultRouter);
        } else {
            throw new \Exception("ERROR: Default Router is not defined at Routers config");
        }

        //session settings
        $sessionConfig = $this->_config->app['session'];
        if ($sessionConfig["autostart"]) {
            if ($sessionConfig["type"] == "native") {
                $this->_session  = new \MVC\Session\NativeSession($sessionConfig["name"],$sessionConfig["lifetime"],$sessionConfig["path"],$sessionConfig["domain"], $sessionConfig["secure"]);
            } else if ($sessionConfig["type"] == "dbsession") {
                $this->_session  = new \MVC\Session\DBSession($sessionConfig["dbConnection"] ,$sessionConfig["name"], $sessionConfig["dbTable"], $sessionConfig["lifetime"], $sessionConfig["path"], $sessionConfig["domain"], $sessionConfig["secure"]);
            } else {
                throw new \Exception("ERROR: There is no valid Session identification parameter in app config -> app['session']['type']");
            }
        }


        // initialize authentication coontroller
        $this->getAuth();
        // and we dispatch ..
        $this->_frontController->dispatcher();
    }

    /**
     * @return GlobalVariables
     */
    public function getGlobals(){
        if ($this->_globals == null) {
            $this->_globals = GlobalVariables::getInstance();
        }
        return $this->_globals;
    }
    public function view(){
        if ($this->_view == null) {
            $this->_view = View::getInstance();
        }
        return $this->_view;
    }

    public function getAuth(){

        if ($this->_auth == null) {
            $this->_auth = Auth::getInstance();
        }
        return $this->_auth;
    }

    /**
     * @param SessionInterface $session
     */public function setSession(Session\SessionInterface $session){
        $this->_session = $session;
    }
    /**
     * @return SessionInterface
     */public function getSession(){
        return $this->_session;
    }


    /**
     * @param string $connectionName
     * @return \PDO
     * @throws \Exception
     */
    public function getDbConnection(string $connectionName = "default"){

        //check if connection name is not false,empty null or whatever
        if (!$connectionName) {
            throw new \Exception("ERROR DB: Connection name is not set!");
        }
        // check if the connection is not cached
        if (isset($this->_DbConnections[$connectionName])) {
            return $this->_DbConnections[$connectionName];
        }
         // check get the config file for database
        $dbConfigs = $this->_config->database;
        // check if there is a config file for this connectrion
        if (!isset($dbConfigs[$connectionName])) {
            throw new \Exception("ERROR DB: There is no such configuration in the database config file");
        }
        //get the connection settings
        $dbConfig = $dbConfigs[$connectionName];
        //createArticle new PDO connection

        $currentDBConn = new \PDO($dbConfig["connection_url"],
            $dbConfig["username"],
            $dbConfig["password"],
            $dbConfig["pdo_options"]);

        //Cache the connection for future use
        $this->_DbConnections[$connectionName] = $currentDBConn;
        // return the connection
        return $currentDBConn;
    }
    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->_config;
    }

    //ROUTER FUNCTIONALITY

    /**
     * @param string $routerName
     */
    public function setRouter(string $routerName) {
        $this->_frontController->setRouterSettings([$routerName]);
    }

    /**
     * @return Validation|null
     */public function getValidator(){
        if ($this->_validator == null) {
            $this->_validator = Validation::getInstance();
        }
        return $this->_validator;
    }
    /**
     * @return InputData|null
     */public function inputData(){
        if ($this->_inputData == null) {
            $this->_inputData = InputData::getInstance();
        }
        return $this->_inputData;
    }

//    public function _exceptionHandler(\Exception $exception){
//
//        if (isset($this->_config) && isset($this->_config->app["displayExceptions"])) {
//            echo "<pre>" . print_r($exception, true) . "</pre>";
//        } else {
//            $this->displayError($exception->getCode());
//        }
//    }

//    public function displayError($errorCode) {
//        try{
//            $this->view()->render("errors/".$errorCode);
//        }catch (\Exception $e){
//            die($e->getMessage());
//        }
//
//    }

    /**
     *
     */public function __destruct()
    {
        if ($this->_session != null) {
            $this->_session->saveSession();
        }
        if ($this->_config->app["debugging"]) {
            echo "Aplication executed for : ". (microtime(true) - $this->applicationStartedTimer) ." seconds".PHP_EOL;
        }

    }
}
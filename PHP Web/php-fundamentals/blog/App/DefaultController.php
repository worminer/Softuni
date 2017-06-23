<?php


namespace MVC;


/**
 * Class DefaultController
 * controllers can implement this so they will have access to thouse stuff
 * @package MVC
 */
class DefaultController
{
    /**
     * @var App
     * holds an instance of App
     */
    public $app;
    /**
     * @var View
     * holds an instance of View
     */
    public $view;
    /**
     * @var Validation
     * holds an instance of Validation
     */
    public $validate;
    /**
     * @var Config
     * holds an instance of Config
     */
    public $config;
    /**
     * @var InputData
     * holds an instance of InputData
     */
    public $input;

    public $auth;

    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->app      = \MVC\App::getInstance();
        $this->view     = \MVC\View::getInstance();
        $this->validate = \MVC\Validation::getInstance();
        $this->config   = \MVC\Config::getInstance();
        $this->input    = \MVC\InputData::getInstance();
        $this->auth     = \MVC\Auth::getInstance();
    }
}
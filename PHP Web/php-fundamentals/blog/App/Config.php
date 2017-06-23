<?php


namespace MVC;


/**
 * Class Config
 *
 * @package MVC
 */
class Config
{
    /**
     * @var null
     * holds instance of this object
     */
    private static $_instance = null;
    /**
     * @var string
     * holds config folder path
     */
    private $configFolderPath;
    /**
     * @var array
     * holds all config paths
     */
    private $configFolderFilesArrays = [];


    /**
     * Config constructor.
     * its private one becouse its singleton
     */
    private function __construct()
    {
    }


    /**
     * @param string $configFolder
     * @throws \Exception
     */
    public function setConfigFolder(string $configFolder){
        if (!$configFolder) {
            throw new \Exception("ERROR: Config folder path is not valid path - {$configFolder}");
        }
        $configFolder = realpath($configFolder);
        if ($configFolder && is_dir($configFolder)) {
            if (!is_readable($configFolder)) {
                throw new \Exception("ERROR: Config folder path is not readable - {$configFolder} ");
            }
            $this->configFolderPath = $configFolder.DIRECTORY_SEPARATOR;
            $this->autoInitializeNamespaces();
        }else {
            throw new \Exception("ERROR: This Path to config folder is not correct - {$configFolder}");
        }
    }
    
    public function includeConfigFile($pathToFile){
        if (!$pathToFile) {
            throw new \Exception("ERROR: Path not set - {$pathToFile}");  
        }

        $realPathToFile = realpath($pathToFile);

        if ($realPathToFile && is_file($realPathToFile)) {
            if (!is_readable($realPathToFile)) {
                throw new \Exception("ERROR: File is not readable - {$realPathToFile}");
            }
            $fileName = explode(".php", basename($realPathToFile))[0];
            
            $this->configFolderFilesArrays[$fileName] = include $realPathToFile;
        } else {
            echo $realPathToFile.' as '.$pathToFile;
            throw new \Exception("ERROR: This Path to config file is not correct - {$pathToFile}");
        }
    }

    public function __get(string $name){
        // check if this array of data does not exist.. fetch it from the file
        if (!array_key_exists($name,$this->configFolderFilesArrays)) {
            $this->includeConfigFile($this->configFolderPath.$name.".php");
        }
        // if data exist (fetch was successful) then return the data..
        if (array_key_exists($name , $this->configFolderFilesArrays)) {
            return $this->configFolderFilesArrays[$name];
        }

        return null; // return null because there might be a true/false as config
    }
    /**
     * @return Config
     */
    public static function getInstance():Config{
        if (self::$_instance == null) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    public function autoInitializeNamespaces(){
        // if there is an properti in app called namespaces and it is and array .. thouse namespaces will be utoloaded
        if (isset($this->app["namespaces"])) {
            $namespaces = $this->app["namespaces"];
            // if it is an array and have at least one element then we autoload the array as namespaces
            if (is_array($namespaces) && count($namespaces) > 0) {
                AutoLoader::registerNamespaces($namespaces);
            }
        }

    }

    public function getConfigFolderPath()
    {
        return $this->configFolderPath;
    }

    /**
     * @return array
     */
    public function getConfigFolderFilesArrays(): array
    {
        return $this->configFolderFilesArrays;
    }

}
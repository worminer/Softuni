<?php
namespace MVC;

/**
 * Class AutoLoader
 * it's final so no one can extend it!
 * it's with empty constructor so no one can make instances of it !
 * @package MVC
 */
final class AutoLoader {

    /**
     * @var array
     * will hold registered namespaces!
     */
    private static $namespaces = [];
    /**
     * Loader constructor.
     * it's with empty constructor so no one can make instances of it ! pls don't delete !
     */
    public function __construct()
    {
    }

    /**
     * will register method autoload to the spl autoload  Gods :)
     */
    public static function registerAutoLoad(){
        spl_autoload_register(array('\MVC\AutoLoader', "autoLoad"));
    }

    /**
     * @param string $class
     * will receive class and namespace to load.. it is a callback from the SPL autoload
     */
    public static function autoload(string $class) {
        self::loadClass($class);
    }

    public static function loadClass(string $class) {
        foreach ( self::$namespaces as $namespace => $path) {
            if (strpos($class, $namespace) === 0) {
                $filePath = str_replace("\\", DIRECTORY_SEPARATOR , $class); // change the \ in the path with the real os path reperator
                $filePath = substr_replace($filePath, $path, 0 , strlen($namespace)).".php";
                $realFilePath = realpath($filePath);
                // if this path does not exist, throw an exception!
                if (!$realFilePath) {
                    throw new \Exception("ERROR: File does not exist - {$filePath}");
                }
                // if this file is not readable for some reason, throw an exception!
                if (!is_readable($realFilePath)) {
                    throw new \Exception("ERROR: This File is not readable - {$realFilePath}");
                }
                // if everything is ok.. include and break;
                include $realFilePath;
                break;
            }
        }
    }
    /**
     * @param string $namespace
     * @param string $pathToFolder
     * @throws \Exception
     */
    public static function registerNamespace (string $namespace, string $pathToFolder) {
        $namespace = trim($namespace); // trim this because someone else can use it.. and put something like space..

        //if the $namespace is empty or not valid string.. throws an error!
        if (strlen($namespace) <= 0) {
            throw new \Exception("ERROR: Invalid namespace - {$namespace}");
        }
        // if $pathToFolder is empty (maybe have to us empty()? ), throws an error!
        if (!$pathToFolder) {
            throw new \Exception("ERROR: Invalid path - {$pathToFolder}");
        }
        $pathToFolder = realpath($pathToFolder);
            // if the realpath() returns false or this is not a proper folder path .. throws an error!
        if ($pathToFolder && is_dir($pathToFolder)) {
            if (!is_readable($pathToFolder)) {
                // if the folder is not readable, throws an error
                throw new \Exception("ERROR:Path is not readable - {$pathToFolder}");
            }

            // if everything is ok .. set it as a valid [namespace => path]
            self::$namespaces[$namespace.'\\'] = $pathToFolder.DIRECTORY_SEPARATOR;
        }else {
            throw new \Exception("ERROR: This Path to folder is not correct - {$pathToFolder}");
        }
    }

    public static function registerNamespaces(array $namespaces){
        if (is_array($namespaces)) {
            foreach ($namespaces as $namespace => $path) {
                self::registerNamespace($namespace, $path);
            }
        }
    }
}
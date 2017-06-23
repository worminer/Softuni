<?php
namespace MVC;

class View {

    /**
     * @var View
     */
    private static $_instance = null;
    /**
     * @var Config
     */
    private $_config = null;

    /**
     * @var string
     */
    private $layoutName; // layout to load
    /**
     * @var string
     */
    private $viewName; // view to load
    /**
     * @var array
     */
    private $data = []; // data to load
    /**
     * @var MessagesManager
     *  holds instance of massage manager
     */
    private $_messageManager = null;
    /**
     * @var
     * holds the loaded html
     */
    private $html;
    /**
     * @var array
     * hold the view configuration array
     */
    private $viewConfig = null;

    private $_globals = null;
    /**
     * @param string $view
     * @param array  $data
     * @param array  $messages
     * @param string|null $layout
     */
    public function render(string $view, array $data = [], array $messages = [], string $layout = null){
        
        $this->viewConfig = $this->getConfig()->view;
        $this->viewName = $view;
        $this->data = array_merge($this->data, $data);
        if ($layout == null) {
            $this->layoutName = $this->viewConfig["DEFAULT_LAYOUT"];
        } else {
            $this->layoutName = $layout;
        }

        // start doing the hard work

        if ($this->getConfig()->app["debugging"]) {
            $startTime = microtime(true);
        }

        $this->_globals = GlobalVariables::getInstance();

        $this->loadLayout();

        $this->insertBodyView();

        $this->insertAllPartials();

        $this->insertMessages();

        $this->replaceGlobalVariables();

        $this->replaceVariables();

        $this->executeHelperBlocks();

        if (isset($this->getConfig()->app["auto_insert_site_root"]) && $this->getConfig()->app["auto_insert_site_root"] === true) {
           $this->insertURLPublicFolderPrefix($this->getConfig()->app["site_root"]);
        }


        if ($this->getConfig()->app["debugging"]) {
            echo "Template Engine -> View Preparation time : ". (microtime(true) - $startTime) ." seconds".PHP_EOL;
        }

        die($this->getHtml()) ;
    }

    /**
     * @param string$path
     * @param array|string $messages
     * @param string $type
     */
    public function redirect(string $path,$messages = null, $type = "error") {
        // TODO: да се направи проверка дали съобщението е от позволените типове..
        if ($messages != null) {
            $this->getMessageManager()->setMessage($type, $messages);
        }
        // redirecting
        if ($this->getConfig()->app["auto_insert_site_root"]) {
            header("Location: {$this->getConfig()->app["site_root"]}{$path}");
        } else {
            header("Location: {$path}");
        }

        die(); // not needed but in any case ..
    }

    /**
     *
     */
    public function insertMessages(){
        $globals = GlobalVariables::getInstance();
        $messages = $this->getMessageManager()->getAllMessages();
        if (array_key_exists("success",$messages)) {
            $globals->setGlobalVar("messagesSuccess",$messages["success"]);

        }
        if (array_key_exists("error",$messages)) {
            $globals->setGlobalVar("messagesError",$messages["error"]);
        }
        if (array_key_exists("warning",$messages)) {
            $globals->setGlobalVar("messagesWarning",$messages["warning"]);
        }
        $this->getMessageManager()->flushAllMessages();
    }

    /**
     * @return MessagesManager
     */
    public function getMessageManager(){

        if (!$this->_messageManager INSTANCEOF MessagesManager) {
            $this->_messageManager = MessagesManager::getInstance();
        }
        return $this->_messageManager;
    }

    public function getConfig(){
        if ($this->_config == null) {
            $this->_config = Config::getInstance();
        }
        return $this->_config;
    }

    /**
     * @return View
     */
    public static function getInstance():View{
        if (self::$_instance == null) {
            self::$_instance = new View();
        }
        return self::$_instance;
    }


    /**
     * @throws \Exception
     */
    private function loadLayout(){

        $layoutPath = $this->viewConfig["VIEW_FOLDER"].DIRECTORY_SEPARATOR.$this->getLayoutName().$this->viewConfig["TEMPLATE_EXT"];

        if (!file_exists($layoutPath)) {
            throw new \Exception("Error loading template file ($layoutPath).");
        }
        $this->setHtml(file_get_contents($layoutPath));
    }

    /**
     * @param string $viewName
     * @return string
     */
    private function loadView(string $viewName){
        $viewPath = $this->viewConfig["VIEW_FOLDER"].DIRECTORY_SEPARATOR.$viewName."View".$this->viewConfig["TEMPLATE_EXT"];
        if (!file_exists($viewPath)) {
            return "Error loading View file ($viewPath).";
        }
        return file_get_contents($viewPath) ;
    }

    /**
     *
     */
    private function insertBodyView() {
            $this->setHtml(str_replace($this->viewConfig["TEMPLATE_BODY_TAG"], $this->loadView(trim($this->getViewName())), $this->getHtml()));
    }

    /**
     *  will check for helpers and execute them
     */
    private function executeHelperBlocks(){
        $viewConfig =  $this->viewConfig;
        $findIfElseBlock = '/' . $viewConfig["IF_BLOCK_START"] . '(?:.*?)' . $viewConfig["IF_BLOCK_END"] . '/si'; // matches everything between {{#if author}} and {{/if}}
        $findUnlessBlock = '/'. $viewConfig["UNLESS_BLOCK_START"] . '(?:.*?)' . $viewConfig["UNLESS_BLOCK_END"] .'/si'; // matches Unless block
        $findEachBlock   = '/'. $viewConfig["EACH_BLOCK_START"] . '(?:.*?)' . $viewConfig["EACH_BLOCK_END"] .'/si'; // matches Each block
        $findIndexedArr  = '/'. $viewConfig["TEMPLATE_VARIABLE_INDEXED_ARRAY"].'/si'; // matches indexed array
        $findAssocArr    = '/'. $viewConfig["TEMPLATE_VARIABLE_ASSOC_ARRAY"].'/si'; // matches assoc array

        $this->setHtml(preg_replace_callback_array(
            [
                $findIfElseBlock    => function ($match) {return $this->preformIfBlock($match[0]);},
                $findUnlessBlock    => function ($match) {return $this->preformUnlessBlock($match[0]);},
                $findEachBlock      => function ($match) {return $this->preformEachBlock($match[0]);},
                $findIndexedArr     => function ($match) {return $this->preformVariableArray($match);},
                $findAssocArr       => function ($match) {return $this->preformVariableArray($match);},
            ]
            ,$this->getHtml(),-1,$expressionCounter)
        );
    }

    private function preformVariableArray($match){
        if ($match[1] == "@") {
            $variablePool = GlobalVariables::getInstance()->getAllGlobalVar();
        } else if($match[1] == "#"){
            $variablePool = $this->data;
        }
        $needleVarName = $match[2];
        $result = '';
        if (!isset($variablePool[$needleVarName])) {
            return "/no such var/";
        }
        $currentVar = $variablePool[$needleVarName];
        $key = $match[3];
        if (!isset($currentVar[$key])) {
            return "/no such key/";
        }

        $result = $currentVar[$key];

        return $result;
    }

    private function preformEachBlock(string $block){

        $viewConfig =  $this->viewConfig;
        preg_match('/' . $viewConfig["EACH_BLOCK_START"] . '/i',$block,$matchesIF); // find if there is else in the if block
        if ($matchesIF[2] == "@") {
            $variablePool = GlobalVariables::getInstance()->getAllGlobalVar();
        } else {
            $variablePool = $this->data;
        }
        $needleVarName = $matchesIF[3];  // get the variable name

        $currentVar = null;
        // check if variable is set and if it is not we return the original input
        if (array_key_exists($needleVarName,$variablePool)) {
            $currentVar = $variablePool[$needleVarName];
        } else {
            return '';
        }

        // if this is not an array return the block back
        if (!is_array($currentVar)) {
            return "/not an array/";
        }

        // check if there is and else block
        preg_match('/' . $viewConfig["EACH_BLOCK_ELSE"] . '/i',$block,$matchesElse); // find if there is else in the if block

        if (count($matchesElse) > 0) {
            preg_match('/' . $viewConfig["EACH_BLOCK_START"] . '(.*)' . $viewConfig["EACH_BLOCK_ELSE"] . '(.*)' . $viewConfig["EACH_BLOCK_END"] . '/si',$block,$matchesParts);
            // check if the if statement is true or false and return the proper awnser
            //var_dump($matchesParts);
            if (count($currentVar) > 0) {
                $matchedString = $matchesParts[4];
            } else {
                $matchedString = $matchesParts[6];
            }
        } else {
            preg_match('/' . $viewConfig["EACH_BLOCK_START"] . '(.*)' . $viewConfig["EACH_BLOCK_END"] . '/si',$block,$matchesParts);
            // check if the if statement is true or false and return the proper awnser
            if (count($currentVar) > 0) {
                $matchedString = $matchesParts[4];
            } else {
                $matchedString = '';
            }
        }

        $result = "";
        if (count($currentVar) == 0) {
            $result = $matchedString;
        }

        $counter = 0;
        // parse the string and put the variables inside
        foreach ($currentVar as $key => $value){
            if (is_array($value)) {
                $valueString = Utill::implodeRecursive(" ",$value);
                $valueArr = $value;
            } else {
                $valueString = $value;
                $valueArr = null;
            }

            $values = [
                'key'         => $key,
                'valueString' => Utill::xss_clean($valueString),
                'valueArr'    => $valueArr,
                'index'       => $counter,
                'number'      => $counter+1,

            ] ;

            $patterns = [
                '/'.$viewConfig["EACH_BLOCK_KEY_PARAM"].'/si'          => function ($match) use (&$values){return $values["key"];},
                '/'.$viewConfig["EACH_BLOCK_VALUE_PARAM"].'/si'        => function ($match) use (&$values){return $values["valueString"];},
                '/'.$viewConfig["EACH_BLOCK_VALUE_PARAM_INDEXED"].'/si'=> function ($match) use (&$values){

                    $currentValues = $values["valueArr"];
                    if (!is_array($currentValues)) {
                        return "/no an array/";
                    }

                    if (count($currentValues) <= 0) {
                        return "/empty array/";
                    }

                    if (!isset($currentValues[$match[1]])) {
                        return "/no such key in array/";
                    }
                    return $currentValues[$match[1]];
                },
               '/'.$viewConfig["EACH_BLOCK_VALUE_PARAM_ASSOC"].'/si'  => function ($match) use (&$values){
                    $currentValues = $values["valueArr"];
                    if (!is_array($currentValues)) {
                        return "/no an array/";
                    }

                    if (count($currentValues) <= 0) {
                        return "/empty array/";
                    }

                    if (!isset($currentValues[$match[1]])) {
                        return "/no such key in array/";
                    }
                    //var_dump($match);
                    return Utill::xss_clean($currentValues[$match[1]]);
                },
                '/'.$viewConfig["EACH_BLOCK_INDEX_PARAM"].'/si'        => function ($match) use (&$values){return $values["index"];},
                '/'.$viewConfig["EACH_BLOCK_NUMBER_PARAM"].'/si'       => function ($match) use (&$values){return $values["number"];},

            ] ;

            $result .= preg_replace_callback_array ( $patterns, $matchedString, -1, $expressionCounter);
            $counter++;
        }
        return $result ;


    }

    private function preformUnlessBlock(string $block){

        preg_match('/' . $this->viewConfig["UNLESS_BLOCK_START"] . '/i',$block,$matchesIF); // find if there is else in the if block
        $varName = $matchesIF[2];  // get the variable name

        $boolVariable = null;
        // check if variable is set and if it is not we return the original input
        if (isset($this->data[$varName])) {
            $boolVariable = $this->data[$varName];
        } else {
            return "";
        }

        preg_match('/' . $this->viewConfig["UNLESS_BLOCK_START"] . '(.*)' . $this->viewConfig["UNLESS_BLOCK_END"] . '/si',$block,$matchesParts);
        // check if the if statement is true or false and return the proper awnser
        if ((bool)$boolVariable === false) {
            return $matchesParts[3];
        } else {
            return '';
        }
    }

    private function preformIfBlock(string $block):string {
        preg_match('/' . $this->viewConfig["IF_BLOCK_START"] . '/i',$block,$matchesIF); // find if there is else in the if block

        if ($matchesIF[2] == "@") {
            $variablePool = GlobalVariables::getInstance()->getAllGlobalVar();
        } else {
            $variablePool = $this->data;
        }

        $currentVar = $matchesIF[3];  // get the variable name
        $existVariable = false;
        $displayElse = false;
        // check if variable exist and if it is not we return the empty input
        if (array_key_exists($currentVar,$variablePool)) {
            $existVariable = (bool)$variablePool[$currentVar];
        }

        // check if there is and else block
        preg_match('/' . $this->viewConfig["IF_BLOCK_ELSE"] . '/i',$block,$matchesElse); // find if there is else in the if block

        if (count($matchesElse) > 0) {
            preg_match('/' . $this->viewConfig["IF_BLOCK_START"] . '(.*)' . $this->viewConfig["IF_BLOCK_ELSE"] . '(.*)' . $this->viewConfig["IF_BLOCK_END"] . '/si',$block,$matchesParts);
            // check if the if statement is true or false and return the proper awnser
            if ($existVariable === true) {
                return $matchesParts[4];
            } else {
                return $matchesParts[6];
            }
        } else {
            preg_match('/' . $this->viewConfig["IF_BLOCK_START"] . '(.*)' . $this->viewConfig["IF_BLOCK_END"] . '/si',$block,$matchesParts);
            // check if the if statement is true or false and return the proper awnser
            if ($existVariable === true) {
                return $matchesParts[4];
            } else {
                return '';
            }
        }
    }
    /**
     * inserts path to public dir in all local links
     * href="home/index" becomes href="/Path/To/Public/home/index"
     * @param $publicFolder
     */
    private function insertURLPublicFolderPrefix($publicFolder){
        // matches src="" or src=''
        $patterns[] = '/(?<=(?>src=)(?>\'|"))([^http|#](?>\/|)(?>\w+(?:\/|\.|_|-|))+)(?=(?>\'|"))/i';
        $patterns[] = '/(?<=(?>href=)(?>\'|"))([^http|#](?>\/|)(?>\w+(?:\/|\.|_|-|))+)(?=(?>\'|"))/i';
        $patterns[] = '/(?<=(?>action=)(?>\'|"))([^http|#](?>\/|)(?>\w+(?:\/|\.|_|-|))+)(?=(?>\'|"))/i';

        $this->setHtml(preg_replace_callback($patterns,
            function ($match) use (&$publicFolder){
            //var_dump($match);
            return $publicFolder.$match[1];

        },
            $this->getHtml()));
    }

    /**
     *
     */
    private function replaceVariables() {
        foreach ($this->data as $key => $value) {
            if (!is_array($value)) {
                if (is_bool($value)) {
                    if ($value) {
                        $value = "true";
                    } else {
                        $value = "false";
                    }
                }
                $replaceTag = str_replace("%VAR_NAME%"," *".$key." *",$this->viewConfig["TEMPLATE_VARIABLE"]);
                $this->setHtml(preg_replace("/$replaceTag/i", $value, $this->getHtml()));
            }
        }
    }

    /**
     *
     */
    private function replaceGlobalVariables() {
        $globalVariables = GlobalVariables::getInstance()->getAllGlobalVar();

        foreach ($globalVariables as $key => $value) {
            // ignore arrays because they are not supported
            if (!is_array($value)) {
                if (is_bool($value)) {
                    if ($value) {
                        $value = "true";
                   } else {
                        $value = "false";
                   }
                }
                $replaceTag = str_replace("%VAR_NAME%"," *".$key." *",$this->viewConfig["TEMPLATE_GLOBAL_VARIABLE"]);
                $this->setHtml(preg_replace("/$replaceTag/i", (string)$value, $this->getHtml()));
            }
        }
    }

    /**
     *
     */
    private function insertAllPartials(){
        foreach ($this->getListAllPartials() as $partialName) {
            $replaceTag = str_replace("%PARTIAL_NAME%"," *". $partialName ." *",$this->viewConfig["TEMPLATE_PARTIAL"]);
            //echo $replaceTag.PHP_EOL;
            $this->setHtml(preg_replace("/$replaceTag/i", $this->loadPartial($partialName), $this->getHtml()));
            //$this->setHtml(str_replace($replaceTag, "test", $this->getHtml()));
        }
    }

    /**
     * @return mixed
     */
    private function getListAllPartials (){
        $replaceTag = str_replace("%PARTIAL_NAME%"," *(\\w+) *",$this->viewConfig["TEMPLATE_PARTIAL"]);
        preg_match_all($replaceTag,$this->getHtml(),$matches);
        return $matches[1];
    }

    /**
     * @param string $name
     * @return string
     */
    private function loadPartial(string $name){
        $partialPath = $this->viewConfig["PARTIALS_FOLDER"].DIRECTORY_SEPARATOR.$name."Partial".$this->viewConfig["TEMPLATE_EXT"];
        if (!file_exists($partialPath)) {
            return "Error loading Partial file ($partialPath).";
        }
        return file_get_contents($partialPath) ;
    }



    /**
     * @return mixed
     */
    private function getHtml()
    {
        return $this->html;
    }
    /**
     * @param int|string $html
     */
    private function setHtml($html)
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    private function getViewName(): string
    {
        return $this->viewName;
    }

     /**
     * @return string
     */

    public function getLayoutName(): string
    {
        return $this->layoutName;
    }



}
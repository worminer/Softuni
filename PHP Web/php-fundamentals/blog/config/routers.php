<?php
/**ROUTER OPTIONS!**/

/**
 * holds the name of the Default controller
 * first letter will be auto capitalized if needed
 */
$routers["DefaultControllerNamespace"] = "Controllers";
/**
 * holds the name of the Default controller
 * first letter will be auto capitalized if needed
 */
$routers["DefaultController"] = "home";

/**
 * holds the name of the Default controller
 * first letter will be auto capitalized if needed
 */
$routers["DefaultAction"] = "Index";

/** SETTING UP ROUTERS**/

$routers["DefaultRouter"] = "ControllerActionParams";
// this router will mach site.com/Controller/Action/Param1/paramN
$routers["Routers"]["ControllerActionParams"] = [
    "namespace" => "MVC\\Routers",
    "name"      => "CAPRouter", //ControllerActionParamsRouter
];

/**
 * this will rewrite routes
 * app.get('/home/contact/:id',someController,someAction);
 * app.post('/home/contact/:id',someController,someAction);
 */
$routers["Routers"]["UriMach"] = [
    "namespace" => "MVC\\Routers",
    "name"      => "UriMachRouter",
];

return $routers;
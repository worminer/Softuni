<?php
//Aliases and constants
define("DIR",dirname(__FILE__)); // alias for __DIR__

define("DS",DIRECTORY_SEPARATOR); // Alias for DIRECTORY_SEPARATOR because.. Why not use german word instead
define("ROOT",realpath("../")); // project ROOT directory

$config["root_dir"] = realpath("../"); // root dir path

$config["public_dir"] = str_replace('/','\\', str_replace("index.php", '', $_SERVER['SCRIPT_NAME'])); // public dir path.



$config["site_root"] = rtrim(str_replace("index.php", '', $_SERVER['SCRIPT_NAME']), '/'); // site root url path.

/* user profile setup */
$config["profile_image_upload_dir"] = $config["root_dir"].'\public\resources\images\users\profile_images\\';
$config["profile_image_public_path"] = "/resources/images/users/profile_images/";
$config["profile_image_min_size"] = 5; // min picture size in bites
$config["profile_image_max_size"] = 5 * 1024 * 1024; // max picture size in bites
$config["profile_image_formats"] = ["jpg", "jpeg", 'png', 'gif'];
/**
 * if true adds the root dir in front of all local links when rendering
 * use if public dir != DocumentRoot
*/
$config["auto_insert_site_root"] = true;

$config["resources_folder"] = $config["public_dir"].DS.'resources';

$config["site_title"] = "Team Darby Blog"; // site title

$config["debugging"] = false; //debugging mode

/**NAMESPACE OPTIONS!**/
/**
 * this configuration is for autoloading namespaces
 * they have to be a $key => $value pair as "namespace" => "path_to_folder"
 * to start autoloading it have to have at least one key=>value pair
 */
$config["namespaces"] = [
    "Controllers" => $config["root_dir"].DS.'controllers',
    "Models" => $config["root_dir"].DS.'models'
];

/** SESSION CONFIGURATION **/
$config["session"] = [
    "autostart"     => true,
    //"type"          => "dbsession", // for db session
    "type"        => "native",  // for native cookie session
    "name"          => "_sess",
    "lifetime"      => 3600,
    "path"          => "/",
    "domain"        => "",
    "secure"        => false,
    "dbConnection"  => "default", // not required for DB session and not required for native
    "dbTable"       => "sessions", // not required for DB session and not required for native
];
//error handeling TODO:FIX IT
$config["displayExceptions"] = true;

return $config;
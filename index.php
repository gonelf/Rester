<?php

//Path for oauth lib
set_include_path(__DIR__."/library/");

if(!file_exists(__DIR__."/config.php"))
	die("No config file found!");

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/include/DBController.php');
require_once(__DIR__.'/include/ApiResponse.php');
require_once(__DIR__.'/include/SwaggerHelper.php');
require_once(__DIR__.'/include/ResterController.php');
require_once(__DIR__.'/include/ApiCacheManager.php');
require_once(__DIR__.'/include/model/RouteCommand.php');


//TODO; Make this smarter
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-StackMob-Proxy-Plain');
header('X-XRDS-Location: http://' . $_SERVER['SERVER_NAME'] .'/services.xrds.php');

$resterController = new ResterController();

if(isset($_GET["cacheClear"])) {
	ApiCacheManager::clear();
	//exit();
}

if (array_key_exists('_method', $_GET) === true)
{
	$_SERVER['REQUEST_METHOD'] = strtoupper(trim($_GET['_method']));
}

else if (array_key_exists('HTTP_X_HTTP_METHOD_OVERRIDE', $_SERVER) === true)
{
	$_SERVER['REQUEST_METHOD'] = strtoupper(trim($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']));
}

//Include API Versions
if(defined('API_VERSION') && file_exists(__DIR__."/versions/".API_VERSION.".php")) {
	include(__DIR__."/versions/".API_VERSION.".php");
}

// custom methods
$loginCommand = new RouteCommand("POST", "users", "login", function($params = NULL) {
	
	global $resterController;
	
	$filter["name"]=$params["name"];
	// $filter["password"]=md5($params["password"]);
	$filter["password"]=$params["password"];
	
	$result = $resterController->getObjectsFromRouteName("user", $filter);

	$resterController->showResult($result);
	
}, array("login", "password"), "Method to login users");


//Add the command to controller
$resterController->addRouteCommand($loginCommand);

//Disable oauth authentication for certain routes
$resterController->addPublicMethod("POST", "users/login");

//Do the work
$resterController->processRequest($_SERVER['REQUEST_METHOD']);

//We never have to be here
$resterController->showError(405);


?>

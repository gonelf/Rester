<?php

/**
* Sample custom login command
*/
//Create the command
$loginCommand = new RouteCommand("POST", "users", "login", function($params = NULL) {
	
	global $resterController;
	
	$filter["login"]=$params["login"];
	$filter["password"]=md5($params["password"]);
	
	$result = $resterController->getObjectsFromRouteName("user", $filter);

	$resterController->showResult($result);
	
}, array("login", "password"), "Method to login users");

//Add the command to controller
$resterController->addRouteCommand($loginCommand);

//Disable oauth authentication for certain routes
$resterController->addPublicMethod("POST", "users/login");
$resterController->addPublicMethod("GET", "testRoute");

//File processor
$resterController->addFileProcessor("imagenes_poi", "imagen");
$resterController->addFileProcessor("poi", "imagenDefecto");

?>
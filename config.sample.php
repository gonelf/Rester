<?php

//The api version, must have a php file on versions folder to include
define('API_VERSION', "1.0.0");

//Database credentials
define('DBHOST', 'localhost');
define('DBNAME', 'grocery');
define('DBUSER', 'grocery');
define('DBPASSWORD', '3lf#gro#g0n');

//If enabled, verbose log written on error.log
//define('LOG_VERBOSE', true);

//The path where the uploads are saved. Must be writtable by the webserver
define('FILE_UPLOAD_PATH', 'uploads');

//Enables API Cache. For now only APC is implemented
define('CACHE_ENABLED', true);

//Enable OAuth 1.0 Authentication
define('ENABLE_OAUTH', true);

// Enable user filter
define('USER_FILTER', true);
// Define your users table and the user identifier in the other tables so it can filter the results by user
define('USER_TABLE', 'user');
define('USER_ID', 'user_id');
?>
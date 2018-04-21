<?php

declare(strict_types=1);

$start = explode(' ', microtime())[0] + explode(' ', microtime())[1];

/**
 * Front controller
 */

session_set_cookie_params(7776000);

/**
 * Set Default Timezone
 */
date_default_timezone_set("Europe/London");

/**
 * Session things
 */
session_name("cuise");
session_start();

if(empty($_SESSION['csrftoke'])) {
    $_SESSION['csrftoke'] = bin2hex(random_bytes(32));
}

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Headers / Cors
 */
header("Access-Control-Allow-Origin: http".(isset($_SERVER['HTTPS'])?'s':'')."://"."{$_SERVER['HTTP_HOST']}");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 600');
header('X-Frame-Options: SAMEORIGIN');
header("X-XSS-Protection: 1; mode=block");
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');

if(!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') {
	header('Strict-Transport-Security: max-age=31536000');
}

if(\NoBadBots\BeGone::shoo() >= 5){
	die(exit("Please try again later."));
}

/**
 * Include routes from path
 */
require_once("../App/Routes/Main.php");

$router->dispatch($_SERVER['QUERY_STRING']);

$time = explode(' ', microtime());
$time = $time[1] + $time[0];
$total_time = round(($time - $start), 4);

if(!strpos($_SERVER['REQUEST_URI'], 'api') !== false) {
	echo PHP_EOL.'<!-- !!KEEP::'.round((explode(' ', microtime())[0] + explode(' ', microtime())[1]) - $start, 4).'|'.\Core\Database::getTotalQueries().'|'.\NoBadBots\BeGone::$badness.' -->';
}
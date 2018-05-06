<?php

/**
 * Routing Paramaters:
 * [
 *   '(:any)' => '[^/]+',
 *   '(:num)' => '[0-9]+',
 *   '(:az)'  => '[a-z]+',
 *   '(:AZ)'  => '[A-Z]+',
 *   '(:aZ)'  => '[a-zA-Z]+',
 *   '(:aZN)' => '[a-zA-Z0-9]+',
 *   '(:all)' => '.*'
 * ]
 * {paramName:(:item)}
 */
$router = new Core\Router();

/**
 * These are just examples
 */
$router->add(['','home'], ['controller' => 'Home', 'action' => 'index']);
$router->add('about-me', ['controller' => 'Home', 'action' => 'aboutMe']);

$router->add('blog/{str:[^/]+}', ['controller' => 'Blog', 'action' => 'postSlug']);

$router->add('account/dash', function(){
    header("Location: /account/dashboard", 301);
    exit(die());
});

/* Admin Routes */
include_once("Admin.php");

/* API Routes */
include_once("Api.php");

$router->add('404', ['controller' => 'General', 'action' => 'fourOFour']);
$router->add('500', ['controller' => 'General', 'action' => 'fiveOO']);
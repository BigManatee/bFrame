<?php
$router->add('api/search/{str:[^/]+}', ['controller' => 'Api', 'action' => 'Search']);
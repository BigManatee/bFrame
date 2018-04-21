<?php
$router->add('admin', ['controller' => 'Admin\Main', 'action' => 'index']);
$router->add('admin/settings/{str:[^/]+}', ['controller' => 'Admin\Main', 'action' => 'settings']);
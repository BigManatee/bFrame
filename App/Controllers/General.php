<?php

namespace App\Controllers;

use \Core\View;

/**
 * General controller
 */
class General extends \Core\Controller
{

    /**
     * Show the 404 page
     */
    public function fourOFour() {
        View::renderTemplate('404.php');
    }

    /**
     * Show the 500 page
     */
    public function fiveOO() {
        View::renderTemplate('500.php');
    }
}
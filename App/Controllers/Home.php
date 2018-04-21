<?php

namespace App\Controllers;

use \Core\View, 
    \Core\Database;

/**
 * Home controller
 */
class Home extends \Core\Controller {

    /**
     * Show the index page
     */
    public function indexAction() {

        $blogPosts = Database::getAll("SELECT * FROM blog ORDER BY id DESC LIMIT 3",  MYSQLI_ASSOC, true, 6 * 3600, true);
        
        View::renderTemplate('Home/index.php', [
            'blogPosts' => $blogPosts
        ]);
    }

    public function aboutMeAction() {
        View::renderTemplate('Home/about.php', []);
    }

    public function previousWorkAction() {
        $theWork = Database::getAll("SELECT * FROM previouswork ORDER BY id DESC", MYSQLI_ASSOC, true, 4 * 3600, true);

        View::renderTemplate('Home/previousWork.php', [
            'theWork' => $theWork
        ]);
    }
}
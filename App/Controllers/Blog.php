<?php

namespace App\Controllers;

use \Core\View, 
    \Core\Database;

class Blog extends \Core\Controller {

    public function allPostsAction() {
        /**
         * List all blog posts
         */
        $blogPosts = []; // some query to the database

        View::renderTemplate('Blog/all.php', [
            'thePosts' => $blogPosts
        ]);
    }

    public function postSlugAction() {
        /**
         * Display a certain blog post
         */
        $blogPost = []; // some query to the database

        View::renderTemplate('Blog/post.php', [
            'blogPost' => $blogPost
        ]);
    }
}
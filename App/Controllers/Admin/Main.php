<?php

namespace App\Controllers\Admin;

use \Core\View, 
    \Core\Database;

/**
 * Admin controller
 */
class Main extends \Core\Controller {

    public function indexAction() {
    	$rtnMsg = [];
    	if(isset($_SESSION['adm_login'])){ header("Location: /MI3/control-room"); die();}

    	if(isset($_POST['signin'])){
    		if(filter_var($_POST['_login_email'], FILTER_VALIDATE_EMAIL)) {
    			$checkUserMail = Database::numRows("SELECT * FROM users WHERE email = '".Database::secure($_POST['_login_email'])."'", false);
				if($checkUserMail > 0){
					$checkUserMailAndPass = Database::numRows("SELECT * FROM users WHERE email = '".Database::secure($_POST['_login_email'])."' AND password = '".Database::secure(\Core\Users::pwdHash($_POST['_login_password']))."'", false);
					if($checkUserMailAndPass > 0){
						$getUserID = Database::getArray("SELECT id,email FROM users WHERE email = '".Database::secure($_POST['_login_email'])."' AND password = '".Database::secure(\Core\Users::pwdHash($_POST['_login_password']))."'", MYSQLI_ASSOC, false);
						
                        
						  $_SESSION['adm_login'] = true;
						  $_SESSION['user_adm']['id'] = $getUserID['id'];
						  $_SESSION['user_adm']['username'] = $getUserID['email'];

						  header("Location: /MI3/control-room");

                          die(exit());
                        
					} else {
						$rtnMsg = ['type' => 'danger', 'msg' => "Not today, buddy."];
					}
				} else {
					$rtnMsg = ['type' => 'danger', 'msg' => "Not today, buddy."];
				}
			} else {
				$rtnMsg = ['type' => 'danger', 'msg' => "Not today, buddy."];
			}
    	}
        
        View::renderTemplate('Admin/index.php', [
            'rtnMsg' => $rtnMsg
        ]);
    }

    public function controlRoomAction() {
        $rtnMsg = [];
        if(!isset($_SESSION['adm_login'])){ header("Location: /MI3"); die();}

        $blogPosts = Database::getAll("SELECT * FROM blog ORDER BY id DESC", MYSQLI_ASSOC, false, 4 * 3600, true);

        View::renderTemplate('Admin/dash.php', [
            'rtnMsg' => $rtnMsg,
            'user' => [
                'info' => \Core\Users::adminUserInfo()
            ],
            'dash' => [
                'blogPosts' => $blogPosts,
            ]
        ]);
    }

    public function editBlogPostAction() {
    	$rtnMsg = [];
    	if(!isset($_SESSION['adm_login'])){ header("Location: /MI3"); die();}

        $getBlogInfo = Database::getArray("SELECT * FROM blog WHERE id = '".Database::secure($this->route_params['str'])."'", MYSQLI_ASSOC, false, 4 * 3600, true);

        if(isset($_POST['updatepost'])) {
            
            if(isset($_POST['blog_active'])) {
                $isPostActive = '1';
            } else {
                $isPostActive = '1';
            }

            $updateThePost = Database::query("UPDATE blog SET slug = '".Database::secure($_POST['blog_slug'])."',
                title = '".Database::secure($_POST['blog_title'])."',
                preview_img = '".Database::secure($_POST['blog_preview_img'])."',
                body = '".Database::secure($_POST['blog_body'])."',
                tags = '".Database::secure($_POST['blog_tags'])."',
                active = '".$isPostActive."'
                WHERE id = '".Database::secure($this->route_params['str'])."'");

            if($updateThePost) {
                $rtnMsg = ["msg"=>"Post updated"];
            } else {
                $rtnMsg = ["msg"=>"Post updated failed"];
            }
        }

        View::renderTemplate('Admin/edit_blog.php', [
            'rtnMsg' => $rtnMsg,
            'user' => [
            	'info' => \Core\Users::adminUserInfo()
            ],
            'data' => [
                'blogInfo' => $getBlogInfo,
            ]
        ]);
    }
}
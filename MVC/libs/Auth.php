<?php
class Auth {
    /**
     * 
     */
    public static function checkLogin() {
        Session::init();
        if(Session::get('loggedIn') == false) {
            Session::destroy();
            header("location: index.php?controlle=user&action=login");
            exit();
        }
    }
}
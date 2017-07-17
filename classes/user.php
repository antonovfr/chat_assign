<?php
/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package user
 */
//Load the password class
require('password.php');

    class User {

        public function login($hash, $password){
            $pass = new Password();
            if($pass->password_verify($password,$hash) == 1){
                $_SESSION['loggedin'] = true;
                return true;
            } else {
                return false;
            }
        }
        public function logout(){
            session_destroy();
        }

        public function is_logged_in(){
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                return true;
            }
        }
    }
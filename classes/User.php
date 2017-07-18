<?php
/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package User
 */
//Load the password class
require('Password.php');

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
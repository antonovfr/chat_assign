<?php
/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package user
 */
//Load the password class
require('password.php');

    class user {
        /**
         * Name of the user
         * @var string
         */
        private $name;

        public function get_name() {
            return $this -> name;
        }
        public function set_name($name) {
            $this->name = $name;
        }

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
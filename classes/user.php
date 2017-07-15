<?php
/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package user
 */
    class user {
        /**
         * ID assigned to a user at its first connection
         * @var integer
         */
        private static $id;
        /**
         * Name of the user
         * @var string
         */
        private $name;
        function get_id() {
            return self::$id;
        }
        function get_name() {
            return $this -> name;
        }
        function set_name($name) {
            $this->name = $name;
        }
    }
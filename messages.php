<?php
/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package messages
 */
    class messages {
        /**
         * Id of the message used to store it in the database
         * @var integer
         */
        private static $id;
        /**
         * Timestamp at which the message has been written
         * @var integer
         */
        private static $timestamp;
        /**
         * The author of the message
         * @var string
         */
        private static $user;
        /**
         * the content of the message sent
         * @var string
         */
        private static $message;
        function get_id() {
            return self::$id;
        }
        function get_ts() {
            return self::$timestamp;
        }
        function get_user() {
            return self::$user;
        }
        function get_message() {
            return self::$message;
        }
    }
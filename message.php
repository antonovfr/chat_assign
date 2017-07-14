<?php
/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package message
 */
    class message {
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
        private static $author;
        /**
         * The recipient of the message
         * @var string
         */
        private static $recipient;
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
            return self::$author;
        }
        function get_recipient() {
            return self::$recipient;
        }
        function get_message() {
            return self::$message;
        }
    }
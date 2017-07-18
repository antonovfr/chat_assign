<?php

ob_start();
session_start();
//set timezone
date_default_timezone_set('Europe/Amsterdam');

//include the user class
$userpath = $_SERVER['DOCUMENT_ROOT'];
$userpath .= "/classes/User.php";
include_once($userpath);
$user = new User();

//Config file useful for bigger database configuration
$dbpath = $_SERVER['DOCUMENT_ROOT'];
$dbpath .= "/classes/Database.php";
include_once($dbpath);
$db = new ChatDatabase('db/ChatDB.db');

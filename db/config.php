<?php

//include the user class
$userpath = $_SERVER['DOCUMENT_ROOT'];
$userpath .= "/classes/user.php";
include_once($userpath);
$user = new User();

//Config file useful for bigger database configuration
$dbpath = $_SERVER['DOCUMENT_ROOT'];
$dbpath .= "/classes/database.php";
include_once($dbpath);
$db = new CredDatabase('db/ChatDB.db');

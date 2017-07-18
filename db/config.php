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

//Include the database class
$dbpath = $_SERVER['DOCUMENT_ROOT'];
$dbpath .= "/classes/Database.php";
include_once($dbpath);
$db = new ChatDatabase('db/ChatDB.db');

//Include the display class
$dispath = $_SERVER['DOCUMENT_ROOT'];
$dispath .= "/classes/Display.php";
include_once($dispath);
$display = new Display();

//Include the FormProcessing class
$formpath = $_SERVER['DOCUMENT_ROOT'];
$formpath .= "/classes/FormProcessor.php";
include_once($formpath);
$form = new FormProcessor();
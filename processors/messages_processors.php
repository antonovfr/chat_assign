<?php

/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package chat
 */

//include config to the sqlite server
$confpath=$_SERVER['DOCUMENT_ROOT']."/db/config.php";
require_once($confpath);
//include the MessagesProcessor class
$procpath=$_SERVER['DOCUMENT_ROOT']."/classes/MessagesProcessor.php";
require($procpath);

//check if the user doing the request is logged in
if(!$user->isLoggedIn() ){
    http_response_code(403);
    echo "You must be logged in to send request";
}

//Instantiate the processor
$processor = new MessagesProcessor();

if(isset($_GET['action']) && $_GET['action'] == 'retrieve') {
    $processor->retrieveMessages($db);
} elseif(isset($_POST['action']) && $_POST['action'] == 'dispatch') {
    $processor->dispatchMessage($db);
} else {
    http_response_code(403);
    echo "This API can only be used to retrieve or dispatch messages";
}

<?php
//include config to the sqlite server
require_once('db/config.php');
//check if already logged in move to home page
if(!$user->is_logged_in() ){
    http_response_code(403);
    echo "You must be logged in to send request";
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['message']) OR empty($_POST['recipientid'])) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "You must enter a message and a recipient";
        exit;
    }

    if (isset($_POST['message']) && isset($_POST['recipientid'])) {
        $date = new DateTime();
        $date = $date->getTimestamp();
        $db->insert_message($_SESSION['id'], $_POST['recipientid'], $_POST['message'], $date);
        http_response_code(200);
        echo "Message sent";
    }
} else {
    http_response_code(403);
    echo "You cannot access this page with a GET method";
}

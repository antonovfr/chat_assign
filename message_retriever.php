<?php
//include config to the sqlite server
require_once('db/config.php');
//check if already logged in move to home page
if(!$user->is_logged_in() ){
    http_response_code(403);
    echo "You must be logged in to send request";
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (empty($_GET['senderid'])) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "You must enter a sender";
        exit;
    } else {
        $SQLres=$db->fetch_messages_for_conversation($_SESSION['id'],$_GET['senderid']);
        if(!empty($SQLres)) {
            while ($row = $SQLres->fetchArray(SQLITE3_ASSOC)) {
                extract($row);
                if($senderid==$_SESSION['id']){
                    $row['user_name'] = 'me';
                } else {
                    $row['user_name'] = $db->get_user_name($senderid);
                }

                $row['date'] = date('m/d/Y H:i:s', $timestamp);
                $rows[]= $row;
            }
            print json_encode($rows);
        }
    }
} else {
    http_response_code(403);
    echo "You have to use a GET method for this page";
}

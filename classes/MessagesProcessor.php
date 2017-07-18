<?php

/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package chat
 */

class MessagesProcessor
{

    /**
     * Retrieve the messages from the database, process the fields and print it in json
     * @param $db ChatDatabase The database were the messages are stored
     */
    public function retrieveMessages($db)
    {
        if (empty($_GET['senderid'])) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "You must enter a sender";
            exit;
        } else {
            $SQLres=$db->fetchMessagesForConversation($_SESSION['id'],$_GET['senderid']);
            if(!empty($SQLres)) {
                while ($row = $SQLres->fetchArray(SQLITE3_ASSOC)) {
                    extract($row);
                    if($senderid==$_SESSION['id']){
                        $row['user_name'] = 'me';
                    } else {
                        $row['user_name'] = $db->getUserName($senderid);
                    }

                    $row['date'] = date('m/d/Y H:i:s', $timestamp);
                    $rows[]= $row;
                }
                print json_encode($rows);
            }
        }
    }

    /**
     * Store the messages in the database after adding a timestamp to it
     * @param $db ChatDatabase The database were the messages are stored
     */
    public function dispatchMessage($db)
    {
        if (empty($_POST['message']) OR empty($_POST['recipientid'])) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "You must enter a message and a recipient";
            exit;
        }

        if (isset($_POST['message']) && isset($_POST['recipientid'])) {
            $date = new DateTime();
            $date = $date->getTimestamp();
            $db->insertMessage($_SESSION['id'], $_POST['recipientid'], $_POST['message'], $date);
            http_response_code(200);
            echo "Message sent";
        }
    }
}
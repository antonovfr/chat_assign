<?php
/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package message
 */
    class ChatDatabase extends SQLite3 {
            function __construct($db){
                parent::__construct($db);
            }
            public function get_hashed_password($name) {
                try {
                    $statement = $this->prepare('SELECT hash FROM Users WHERE name = :name');
                    $statement->bindValue('name', $name);
                    $Sqliteres = $statement->execute();
                    $res = $Sqliteres->fetchArray();
                    return $res['hash'];

                } catch(Exception $e) {
                    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
                }
            }

            public function lookup_name($name){
                //check if the name is already in use
                $statement = $this->prepare('SELECT name FROM Users WHERE name = :name;');
                $statement->bindValue(':name', $name, SQLITE3_TEXT);
                $Sqliteres = $statement->execute();
                $row = $Sqliteres->fetchArray();
                return $row['name'];
            }

            public function insert_user($name,$hash){
                //insert user into the database
                $statement = $this->prepare('INSERT INTO Users (name,hash) VALUES (:name, :hash)');
                $statement->bindValue(':name', $name,SQLITE3_TEXT);
                $statement->bindValue(':hash', $hash, SQLITE3_TEXT);
                $statement->execute();
            }

            public function get_user_id($name){
                //fetch the id for an user
                $statement = $this->prepare('SELECT id FROM Users WHERE name = :name;');
                $statement->bindValue(':name', $name, SQLITE3_TEXT);
                $Sqliteres = $statement->execute();
                $row = $Sqliteres->fetchArray();
                return $row['id'];
            }

            public function get_user_name($id){
                //fetch the id for an user
                $statement = $this->prepare('SELECT name FROM Users WHERE id = :id;');
                $statement->bindValue(':id', $id, SQLITE3_INTEGER);
                $Sqliteres = $statement->execute();
                $row = $Sqliteres->fetchArray();
                return $row['name'];
            }

            public function fetch_user_list(){
                //fetch the list of user using the chat
                $statement = $this->prepare('SELECT id, name FROM Users');
                $Sqliteres = $statement->execute();
                return $Sqliteres;
            }

            public function fetch_messages_for_conversation($recipientid, $senderid){
                //fetch messages for a specific recipient
                $statement = $this->prepare('SELECT senderid, message, timestamp FROM Messages WHERE recipientid = :recipient AND senderid = :sender OR recipientid = :sender AND senderid = :recipient');
                $statement->bindValue(':recipient', $recipientid, SQLITE3_INTEGER);
                $statement->bindValue(':sender', $senderid, SQLITE3_INTEGER);
                $Sqliteres = $statement->execute();
                return $Sqliteres;
            }

            public function insert_message($senderid,$recipientid,$message,$timestamp){
                //send message to the database
                $statement = $this->prepare('INSERT INTO Messages (senderid,recipientid,message,timestamp) VALUES (:senderid, :recipientid, :message, :timestamp)');
                $statement->bindValue(':senderid', $senderid,SQLITE3_INTEGER);
                $statement->bindValue(':recipientid', $recipientid, SQLITE3_INTEGER);
                $statement->bindValue(':message', $message,SQLITE3_TEXT);
                $statement->bindValue(':timestamp', $timestamp,SQLITE3_INTEGER);
                $statement->execute();
            }
    }
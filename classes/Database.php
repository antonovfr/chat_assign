<?php
/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package chat
 */

/**
 * Database used to store credentials and messages
 * Class ChatDatabase
 */
    class ChatDatabase extends SQLite3
    {
            function __construct($db)
            {
                parent::__construct($db);
            }

            /**
             * Get the hashed password of a user from the database
             * @param $name string Name of the user for which you want to get the stored hash of the password
             * @return string The hashed password or error if an error occur
             */
            public function getHashedPassword($name)
            {
                try {
                    $statement = $this->prepare('SELECT hash FROM Users WHERE name = :name');
                    $statement->bindValue('name', $name);
                    $Sqliteres = $statement->execute();
                    $res = $Sqliteres->fetchArray();
                    return $res['hash'];
                } catch(Exception $e) {
                    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
                    return 'error';
                }
            }

            /**
             * Simple function to check if a user-name is present in the database
             * @param $name string Name to be checked in the database
             * @return string The name returned by the database
             */
            public function lookupName($name)
            {
                //check if the name is already in use
                $statement = $this->prepare('SELECT name FROM Users WHERE name = :name;');
                $statement->bindValue(':name', $name, SQLITE3_TEXT);
                $Sqliteres = $statement->execute();
                $row = $Sqliteres->fetchArray();
                return $row['name'];
            }

            /**
             * Store the hashed password and the correspondant user-name in the database
             * @param $name string Name of the user
             * @param $hash string Hash of the user password
             */
            public function insertUser($name,$hash)
            {
                //insert user into the database
                $statement = $this->prepare('INSERT INTO Users (name,hash) VALUES (:name, :hash)');
                $statement->bindValue(':name', $name,SQLITE3_TEXT);
                $statement->bindValue(':hash', $hash, SQLITE3_TEXT);
                $statement->execute();
            }

            /**
             * Get the identifier of a user
             * @param $name string Name of the user for who we request the ID
             * @return integer ID of the user in the database
             */
            public function getUserId($name)
            {
                //fetch the id for an user
                $statement = $this->prepare('SELECT id FROM Users WHERE name = :name;');
                $statement->bindValue(':name', $name, SQLITE3_TEXT);
                $Sqliteres = $statement->execute();
                $row = $Sqliteres->fetchArray();
                return $row['id'];
            }

            /**
             * Opposite of the get_user_id function, take an ID and give back the corresponding name in the database
             * @param $id integer The ID we want to know the corresponding name for
             * @return string The name of the user that correspond to the ID in the database
             */
            public function getUserName($id)
            {
                //fetch the id for an user
                $statement = $this->prepare('SELECT name FROM Users WHERE id = :id;');
                $statement->bindValue(':id', $id, SQLITE3_INTEGER);
                $Sqliteres = $statement->execute();
                $row = $Sqliteres->fetchArray();
                return $row['name'];
            }

            /**
             * Fetch the list of all the users from the database
             * @return SQLite3Result An object that contains all the users from the database
             */
            public function fetchUserList()
            {
                //fetch the list of user using the chat
                $statement = $this->prepare('SELECT id, name FROM Users');
                $Sqliteres = $statement->execute();
                return $Sqliteres;
            }

            /**
             * Fetch all the messages that are part of the conversation between a sender and a recipient
             * @param $recipientid integer The ID of the recipient
             * @param $senderid integer The ID of the sender
             * @return SQLite3Result An object that contains all the messages from this conversation
             */
            public function fetchMessagesForConversation($recipientid, $senderid)
            {
                //fetch messages for a specific recipient
                $statement = $this->prepare('SELECT senderid, message, timestamp FROM Messages WHERE recipientid = :recipient AND senderid = :sender OR recipientid = :sender AND senderid = :recipient ORDER BY timestamp');
                $statement->bindValue(':recipient', $recipientid, SQLITE3_INTEGER);
                $statement->bindValue(':sender', $senderid, SQLITE3_INTEGER);
                $Sqliteres = $statement->execute();
                return $Sqliteres;
            }

            /**
             * Insert a message sent in the database
             * @param $senderid integer Sender of the message
             * @param $recipientid integer Recipient of the message
             * @param $message string Message sent
             * @param $timestamp integer Time at which the message has been sent
             */
            public function insertMessage($senderid,$recipientid,$message,$timestamp)
            {
                //send message to the database
                $statement = $this->prepare('INSERT INTO Messages (senderid,recipientid,message,timestamp) VALUES (:senderid, :recipientid, :message, :timestamp)');
                $statement->bindValue(':senderid', $senderid,SQLITE3_INTEGER);
                $statement->bindValue(':recipientid', $recipientid, SQLITE3_INTEGER);
                $statement->bindValue(':message', $message,SQLITE3_TEXT);
                $statement->bindValue(':timestamp', $timestamp,SQLITE3_INTEGER);
                $statement->execute();
            }
    }
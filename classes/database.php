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
                //insert into database with a prepared statement
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

            public function fetch_message($name){
                //fetch messages for a specific recipient
            }
    }
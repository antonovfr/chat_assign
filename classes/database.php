<?php

/**
 * Created by PhpStorm.
 * User: antonov
 * Date: 15/07/17
 * Time: 14:44
 */
class CredDatabase extends SQLite3
{
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
        //$id = $this->lastInsertRowID();
        //return $id;
    }
}
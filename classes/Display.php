<?php

/**
* @author: Nicolas Merle
* @version 1.0
* @package chat
*/


class Display
{
    /**
     * Display all the users from the database in a nice html format
     * @param $db ChatDatabase The database where the users are stored
     */
    public function displayUsersHTML($db)
    {
        $SQLres=$db->fetchUserList();
        if(!empty($SQLres)) {
            while ($row = $SQLres->fetchArray(SQLITE3_ASSOC)){
                extract($row);
                if($id != $_SESSION['id']) {
                    echo "<button class='list-group-item clickable' value='{$id}'>{$name}</button>";
                }
            }
        }
    }
}
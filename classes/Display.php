<?php

/**
* @author: Nicolas Merle
* @version 1.0
* @package Display
*/


class Display
{
    function displayUsers($db){
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
<?php
//include config to connect to the sqlite server
require_once('db/config.php');
//if not logged in redirect to login page
if(!$user->is_logged_in()){
    header('Location: login.php');
    exit;
}
?>

<?php
require('layout/header.php');

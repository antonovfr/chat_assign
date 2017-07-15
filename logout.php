<?php require('db/config.php');

//logout
$user->logout(); 

//return to index page
header('Location: login.php?action=logout');
exit;
?>
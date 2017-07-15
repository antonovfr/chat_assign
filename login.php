<?php
//include config to connect to the sqlite server
require_once('db/config.php');
//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: home.php'); }

//include simple html header
require('layout/header.php');
?>

<body>
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <h1>Welcome to the bunk chat</h1>
        <h2>Please sign up</h2>
        <form class="form-inline">
            <div class="form-group">
                <label class="sr-only">Name</label>
                <input type="text" class="form-control" id="Name" placeholder="JohnDoe">
            </div>
            <div class="form-group">
                <label class="sr-only" >Password</label>
                <input type="password" class="form-control" id="Passwd" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-default">Sign in</button>
            <p>Need an account? <a class='link' href='index.php'>Sign up</a></p>
        </form>
    </div>
</div>
</body>
<?php require('layout/footer.php');?>
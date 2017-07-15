<?php
//include config to connect to the sqlite server
require_once('db/config.php');
//Load the password class
require_once('classes/password.php');
//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: home.php'); }

//process information send when submit is pressed
if(isset($_POST['submit'])){
    if($_POST['name']) {
        if(!empty($db->lookup_name($_POST['name']))){
            $errors[] = 'Name already in use';
        }
    }
    //check if a name was provided
    else {
        $errors[] = 'Enter a name';
    }
    //check if a password was provided
    if(!$_POST['password']){
        $errors[] = 'Enter a password';
    }
    //if no error where raised, carry on with the processing
    if(!isset($errors)){
        //hash the password
        $pass = new Password();
        $hashedpassword = $pass->password_hash($_POST['password'], PASSWORD_BCRYPT);
        try {
            $db->insert_user($_POST['name'],$hashedpassword);
            //redirect to index page after successful sign up
            header('Location: login.php?action=joined');
            exit;
            //else catch the exception and show the error.
        } catch(Exception $e) {
            $errors[] = $e->getMessage();
        }
    }
}


//include simple html header
require('layout/header.php');
?>

<body>
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <h1>Welcome to the bunq chat</h1>
        <h2>Please sign up</h2>
        <?php
        //check for any errors
        if(isset($errors)){
            foreach($errors as $error){
                echo '<p class="bg-danger">'.$error.'</p>';
            }
        }
        ?>
        <form class="form-inline" role="form" method="post" action="" autocomplete="off">
            <div class="form-group">
                <label class="sr-only">Name</label>
                <input type="text" name=name class="form-control" id="name" placeholder="JohnDoe">
            </div>
            <div class="form-group">
                <label class="sr-only" >Password</label>
                <input type="password" name=password class="form-control" id="password" placeholder="Password">
            </div>
            <button type="submit" name='submit' class="btn btn-default">Sign up</button>
            <p>Already an account? <a class='link' href='login.php'>Sign in</a></p>
        </form>
    </div>
</div>
</body>

<?php
//include simple html header
require('layout/footer.php');
?>
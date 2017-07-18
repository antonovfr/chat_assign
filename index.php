<?php
//include config to connect to the sqlite server
require_once('db/config.php');
//check if already logged in move to home page
if($user->isLoggedIn()) {
    header('Location: home.php');
}

//process information send when submit is pressed
if(isset($_POST['submit'])) {
    $errors = $form->signUpFormCheck($db);
    //if no errors were raised, carry on with the processing
    if(!$errors){
        $form->registerUser($db);
    }
}

//define page title
$title = 'Registration page';
//include simple html header
require('layout/header.php');
?>

<body>
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <h1>Welcome to the bunq chat</h1>
        <h2>Please sign up</h2>
        <?php
        //Displaying the errors raised
        if(isset($errors)){
            foreach($errors as $error){
                echo '<p class="bg-danger">'.$error.'</p>';
            }
        }
        ?>
        <form class="form-inline" role="form" method="post" action="" autocomplete="off">
            <div class="form-group">
                <label class="sr-only">Name</label>
                <input type="text" name=name class="form-control" id="name" placeholder="Username">
            </div>
            <div class="form-group">
                <label class="sr-only" >Password</label>
                <input type="password" name=password class="form-control" id="password" placeholder="Password">
            </div>
            <button type="submit" name='submit' class="btn btn-default">Sign up</button>
            <p>Already registered? <a class='link' href='login.php'>Sign in</a></p>
        </form>
    </div>
</div>
</body>

<?php
//include simple html header
require('layout/footer.php');
?>
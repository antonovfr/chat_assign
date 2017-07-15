<?php
//include config to the sqlite server
require_once('db/config.php');
//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: home.php'); }


//process login form if submitted
if(isset($_POST['submit'])){

    $password = $_POST['password'];
    $hash = $db->get_hashed_password($_POST['name']);
    if($user->login($hash,$password)){
        $user-> set_name($_POST['name']);
        header('Location: home.php');
        exit;

    } else {
        $errors[] = 'Wrong username or password.';
    }

}//end if submit

//include simple html header
require('layout/header.php');
?>

<body>
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <h1>Welcome to the bunk chat</h1>
        <h2>Please sign up</h2>
        <?php
        //check for any errors
        if(isset($errors)){
            foreach($errors as $error){
                echo '<p class="bg-danger">'.$error.'</p>';
            }
        }
        if(isset($_GET['action']) && $_GET['action'] == 'joined'){
            echo "<h2 class='bg-success'>Registration successful.</h2>";
        }
        if(isset($_GET['action']) && $_GET['action'] == 'logout'){
            echo "<h2 class='bg-success'>Successfully logged out.</h2>";
        }
        ?>
        <form class="form-inline" role="form" method="post" action="" autocomplete="off">
            <div class="form-group">
                <label class="sr-only">Name</label>
                <input type="text" name='name' class="form-control" id="Name" placeholder="JohnDoe">
            </div>
            <div class="form-group">
                <label class="sr-only" >Password</label>
                <input type="password" name='password' class="form-control" id="Passwd" placeholder="Password">
            </div>
            <button type="submit" name='submit' class="btn btn-default">Sign in</button>
            <p>Need an account? <a class='link' href='index.php'>Sign up</a></p>
        </form>
    </div>
</div>
</body>
<?php require('layout/footer.php');?>
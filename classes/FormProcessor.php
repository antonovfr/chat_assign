<?php

/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package FormProcessing
 */


class FormProcessor
{
    /**
     * Check the form send by the user to sign up. Return errors if anything goes wrong
     * @param $db ChatDatabase The database is used to check if another user with the same name already exist
     * @return array An array containing all the errors that have been raised if any
     */
    function signUpFormCheck($db)
    {
        $errors = [];
        if ($_POST['name']) {
            if (!empty($db->lookupName($_POST['name']))) {
                $errors[] = 'Name already in use';
            }
        } //check if a name was provided
        else {
            $errors[] = 'Enter a name';
        }

        //check if a password was provided
        if (!$_POST['password']) {
            $errors[] = 'Enter a password';
        }
        return $errors;
    }

    /**
     * Register the user in the database if the form checking ended without errors
     * @param $db ChatDatabase The database in which the user will be registered
     * @return array An array containing all the errors that have been raised if any
     */
    function registerUser($db)
    {
        //hash the password
        $pass = new Password();
        $hashedpassword = $pass->password_hash($_POST['password'], PASSWORD_BCRYPT);
        try {
            $db->insertUser($_POST['name'], $hashedpassword);
            //redirect to index page after successful sign up
            header('Location: login.php?action=joined');
            exit;
            //else catch the exception and show the error.
        } catch (Exception $e) {
            $errors[] = 'Something went wrong with the database';
        }
        return $errors;
    }

    /**
     * Login the user on the chat if the login and the password match the one in the database
     * @param $db ChatDatabase The database against which the credentials will be tested
     * @param $user User The user which will be logged in
     * @return array An array containing all the errors that have been raised if any
     */
    function loginUser($db, $user) {
        $errors = [];
        $password = $_POST['password'];
        $hash = $db->getHashedPassword($_POST['name']);
        if($user->login($hash,$password)){
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['id'] = $db->getUserId($_POST['name']);
            header('Location: home.php');
            exit;
        } else {
            $errors[] = 'Wrong username or password.';
        }
        return $errors;
    }
}
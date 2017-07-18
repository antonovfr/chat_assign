<?php

/**
 * @author: Nicolas Merle
 * @version 1.0
 * @package FormProcessing
 */


class FormProcessor
{
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
            $errors[] = $e->getMessage();
            //TODO better exception handling
        }
    }
}
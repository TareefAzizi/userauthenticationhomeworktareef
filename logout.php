<?php 

    session_start();

    //make sure the user is logged in
    if( isset( $_SESSION['user'])) {
        //delete the user's session data
        unset( $_SESSION['user']);
        // redirect user back to index
        header( 'Location: /');
    } else {
        // redirect to login page
        header( 'Location: /login.php');
        exit;
    }
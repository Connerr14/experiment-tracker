<?php

// Making it so we can declare the type of variable we are expecting
declare(strict_types=1);

// Include the config file
include_once 'config_session.inc.php';

// A function to be able to output the user's username to the page
function output_username() {
    // Checking if the user is logged in
    if (isset($_SESSION["user_id"])) {
        // If the user is logged in, output their username
        echo '<li><a href="login.php">Welcome ' . $_SESSION["user_username"] . '</a></li>';
    }
    else {
        echo '<li><a href="login.php">Login/Create Account</a></li>';
    }
}

// A function to check if there were any errors during the login process
function check_login_errors () {
    // Checking if there is a session set in the page
    if (isset($_SESSION["errors_login"])) {
        // Getting the errors from the session
        $errors = $_SESSION["errors_login"];

        // Adding some spacing
        echo "<br>";

        // Looping through the errors and displaying them all on the page
        foreach ($errors as $error) {
            echo "<p class='form-error'>" . $error . "</p>";
        }

        // Cleaning out the errors_login session array
        unset($_SESSION["errors_login"]); 
    }
    // Checking if there is a success message set in the page
    else if ((isset($_GET['login'])) && $_GET['login'] === "success") {
        // If there is a success message in the url, pulled from get, display a success message
        echo "<br>";
        echo "<p class='form-success'>You have successfully logged in!</p>";
    }
}


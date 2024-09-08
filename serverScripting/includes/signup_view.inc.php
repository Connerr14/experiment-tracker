<?php

declare(strict_types=1);

function check_signup_errors() {
    if (isset($_SESSION["errors_signup"])) {
        $errors = $_SESSION["errors_signup"];
        
        foreach ($errors as $error) {
            echo "<p class='form-error'> . $error . </p>";
        }
        unset($_SESSION["errors_signup"]);
    }
    else if ((isset($_GET['signup'])) && $_GET['signup'] === "success") {
        echo "<p>You have successfully signed up!</p>";
        echo "<p id='loginMessage'>Please now login to continue</p>";

        // Hide the form and instructions to emphasize that the user now needs to login
        echo "<style>#createAccount, .formWrapper, #alreadyHaveAnAccount{ display: none; }</style>";
        unset($_SESSION["errors_signup"]);

    }
}
?>
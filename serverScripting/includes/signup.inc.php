<?php


declare(strict_types=1);

    // Checking if the page was accessed through a POST request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieving the form data
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        try {
            // Getting the files needed
            require_once 'dbh.inc.php';
            require_once 'signup_controller.inc.php';
            require_once 'signup_model.inc.php';
            

            // Error Handling

            // Creating a new array to store errors
            $errors = [];

            if (is_email_invalid($email))
            {
                $errors["invalid_email"] = 'Invalid Email Used!';

            }
            if (is_username_taken($pdo, $username))
            {
                $errors["userName_taken"] = 'Username already taken! Please choose another one.';
            }
            if (is_email_registered($pdo, $email))
            {
                $errors["email_registered"] = 'Email already registered! Please use another one.';
            }

            require_once 'config_session.inc.php';

            if ($errors) {

                $_SESSION["errors_signup"] = $errors;
                header('Location: ../../structure/register.php');
                die();
            }


            // Creating the user if no errors are found
            create_user($pdo,$password,$username,$email);

            // Logging the user in
            


            header('Location: ../../structure/register.php?signup=success');




            $pdo = null;
            $stmt = null;

            die();

        }
        catch (PDOException $e) {
            die("Query Failed:" . $e->getMessage());
        }
    }
    else {
        // Redirecting to the form page
        header('Location: ../structure/register.php');
        // Stop the script from running
        die();
    }
?>
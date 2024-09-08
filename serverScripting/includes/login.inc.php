<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Checking if the user got to the page correctly
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Getting the user input
       $username = $_POST["username"];
       $password = $_POST["password"];


        try {
            // Requiring the necessary files
            require_once 'dbh.inc.php';
            require_once 'login_model.inc.php';
            require_once 'login_controller.inc.php';
            
            // Error Handling section

            // Creating a new array to store errors
            $errors = [];
            
            // Checking if the input is empty
            if (is_input_empty($username, $password)) {
                $errors["empty_input"] = 'Please fill in all fields!';
            }

            // Getting the user from the database, passing the db connection and the username
            $result = get_user($pdo, $username);

            // Checking if the username is wrong
            if (is_username_wrong($result)) {
                $errors["login_incorrect"] = 'Incorrect login info!';
            }

            // Checking if the password is wrong
            if (!is_username_wrong($result) && is_password_wrong($password, $result["userPassword"])) {
                $errors["login_incorrect"] = 'Password is incorrect!';
            }

            // Getting the session variables
            require_once 'config_session.inc.php';

            // Checking if there are any errors
            if ($errors) {

                $_SESSION["errors_login"] = $errors;
                header('Location: ../../structure/login.php');
                die();
            }

            // Creating a new session cookie when a user logs in. Associating a session with a user.
            $newSessionId = session_create_id();

            // Append the user id to the session id
            $sessionId = $newSessionId . "-" . $result["userId"];

            // Set the session id
            session_id($sessionId);

            // Setting the user_id and user_username session variables
            $_SESSION["user_id"] = $result["userId"];

            // Removing any html tags from the username
            $_SESSION["user_username"] = htmlspecialchars($result["userName"]);
            
            // Regenerating the session id, so that in 30 mins it will regenerate
            $_SESSION["last_regeneration"] = time();

            header('Location: ../../structure/login.php?login=success');

            // Closing the connection
            $pdo = null;
            $stmt = null;

            // Terminating the script at this point
            die();

        }
        // If the query fails, catch the exception and display the error message
        catch (PDOException $e) {
            die("Query Failed:" . $e->getMessage());
        }
    }
    // If the user did not get to the page correctly, redirect them
    else 
    {
        header("Location: ../../structure/login.php");
        die();
    }


?>
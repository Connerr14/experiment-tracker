<?php
    declare(strict_types=1);

    var_dump($_POST);
    var_dump(is_input_empty($username, $password));

    // A function to check if the input is empty
    function is_input_empty (string $username, string $password) {
        if (empty($username) || empty($password)) {
            return true;
        }
        else {
            return false;
        }
    }

    // A function to return a truthy value on whether the username is wrong
    function is_username_wrong (bool|array $result) {
        // If we get a false value, we return true (as there is no user with that username i.e the username is wrong)
        if (!$result) {
            return true;
        }

        else {
            return false;
        }
    }

    function is_password_wrong (string $password, string $hashedPwd) {
        // Checking if the password is wrong, if it is, return true
        if (!password_verify($password, $hashedPwd)) {
            return true;
        }
        else {
            return false;
        }
    }
?>
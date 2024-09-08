<?php

declare(strict_types=1);


// Checking if the email is invalid
function is_email_invalid(string $email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return true;
    }
    return false;
}

// Checking if the email is invalid, by going through the database and checking if the email is already taken
function is_username_taken(object $pdo, string $username) {
    if (get_username($pdo, $username)) { 
        return true;
    }
    return false;
}

// Checking if the email is registered
function is_email_registered(object $pdo, string $email) {
    if (get_email($pdo, $email)) { 
        return true;
    }
    return false;
}

function create_user(object $pdo, string $password, string $username,string $email) {
    set_user($pdo, $password, $username, $email);
}



?>
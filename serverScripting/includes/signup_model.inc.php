<?php

declare(strict_types=1);
// A function to get usernames from the database
function get_username(object $pdo, string $username) {
    // Creating a prepared statement and executing it
    $query = "SELECT userName FROM user WHERE userName = :userName";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':userName', $username);
    $stmt->execute();

    // Fetching the first result as an assoicate array
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    return $results;
}

// A function to get emails from the database
function get_email(object $pdo, string $email) {
    // Creating a prepared statement and executing it
    $query = "SELECT userName FROM user WHERE email = :email";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Fetching the first result as an assoicate array
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    return $results;
}

// A function to set users in the database
function set_user(object $pdo, string $password, string $username, string $email) {
       // Creating a prepared statement and executing it
       $query = "INSERT INTO user (userName, userPassword, email) VALUES (:userName, :userPassword, :email);";
       $stmt = $pdo->prepare($query);

    //    Assigning 12 to our cost
        $options = [
            'cost' => 12
        ];

        // Hashing the password
        $hashedPwd = password_hash($password, PASSWORD_BCRYPT, $options);

       $stmt->bindParam(':email', $email);
       $stmt->bindParam(':userName', $username);
       $stmt->bindParam(':userPassword', $hashedPwd);
       $stmt->execute();
}
?>
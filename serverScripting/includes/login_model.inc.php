<?php
    // Makes it so that we can declare the type of the variable we are expecting
    declare(strict_types=1);

    // Querying the database for a user
    function get_user (object $pdo, string $username) {
        // Creating a prepared statement and executing it
        $query = "SELECT * FROM user WHERE userName = :userName";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':userName', $username);
        $stmt->execute();

        // Fetching one row from the database
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        return $results;
    }
?>
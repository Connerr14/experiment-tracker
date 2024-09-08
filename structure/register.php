<?php
    // Output all errors
    ini_set('display_errors', 1);
    
    // Linking to session configuration file and login view file
    require_once "../serverScripting/includes/config_session.inc.php";
    require_once "../serverScripting/includes/login_view.inc.php";
    require_once "../serverScripting/includes/signup_view.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Register an account with us to get started">
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/login.css">
    <title>Register Account</title>
</head>
<body id="registerPage">
    <header>
        <?php
            include "../serverScripting/includes/navigation/globalHeader.php";  
        ?>
    </header>
    <h1>Create Account</h1>
    <p id="createAccount">Please enter your details to create an account</p>
    <div class="formWrapper">
        <form action="../serverScripting/includes/signup.inc.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <button type="submit">Register</button>
        </form>
    </div>
    <p id="alreadyHaveAnAccount">Already have an account?</p>
    <a id="login" href="login.php">Login Here</a>
    <?php
        // Check for any signup errors, display them in the html if there is 
        check_signup_errors();
    ?>
    <footer>
        <?php
            include "../serverScripting/includes/navigation/globalFooter.php";
        ?>
    </footer>
</body>
</html>
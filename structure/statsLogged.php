<!DOCTYPE html>
<?php
    require_once '../serverScripting/includes/config_session.inc.php';
    require_once '../serverScripting/includes/login_view.inc.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats Logged</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body id="statsLoggedPage">
    <header>
        <?php
            include "../serverScripting/includes/navigation/globalHeader.php";
        ?>
    </header>
    <main>
        <div class="mainContent">
            <h1>Stats Logged</h1>
            <p>Success! Your stats have been logged.</p>
            <p><a href="index.php">Go back to the main page</a></p>
        </div>
    </main>
    <footer>
        <?php
            include "../serverScripting/includes/navigation/globalFooter.php";
        ?>
    </footer>
</body>
</html>
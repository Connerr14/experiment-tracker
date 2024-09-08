<!DOCTYPE html>
<?php
    
    // Linking to session configuration file and login view file
    require_once "../serverScripting/includes/config_session.inc.php";
    require_once "../serverScripting/includes/login_view.inc.php";
    require_once "../serverScripting/includes/experiments/experimentModel.inc.php";
    require_once "../serverScripting/includes/experiments/experimentController.inc.php";
    require_once "../serverScripting/includes/experiments/experimentView.inc.php";
    require_once "../serverScripting/includes/login_view.inc.php";
    require_once "../serverScripting/includes/dbh.inc.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>See Your Stats</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body id="statsPage">
    <header>
        <?php
            include "../serverScripting/includes/navigation/globalHeader.php";
        ?>
    </header>
    <main>
        <h1>Experiment Results</h1>
        <p>See your experiment details below!</p>
        <!-- General container for results -->
        <div id="general-wrapper">
            <?php
                show_experiment_status($pdo);
            ?>
        </div>

    </main>
    <footer>
        <?php
            include "../serverScripting/includes/navigation/globalFooter.php";
        ?>
    </footer>
</body>
</html>
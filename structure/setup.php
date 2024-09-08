<!DOCTYPE html>
<?php
    require_once '../serverScripting/includes/config_session.inc.php';
    require_once '../serverScripting/includes/login_view.inc.php';
    require_once '../serverScripting/includes/experiments/experimentView.inc.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Sleep Experiment Setup</title>
</head>
<header>
    <?php
        include "../serverScripting/includes/navigation/globalHeader.php";
    ?>
</header>
<body class="form" id="setupExperimentPage">
    <h1>Set Up Your Sleep Experiment</h1>
    <?php
        check_if_logged_in();
        outputErros();

        // Clear the session variable after the errors have been output
        if (isset($_SESSION["errors_experiment"])) {
            unset($_SESSION["errors_experiment"]);
        }
    ?>
    
    <form action="../serverScripting/includes/experiments/experiment.inc.php" method="post">
        <label for="experiment-name" required>Experiment Name:</label>
        <input type="text" id="experiment-name" name="experiment_name" required><br><br>

        <label for="sleep-amount">Current Sleep Amount (hours):</label>
        <input type="number" id="sleep-amount" name="sleep_amount" min="0" max="24" required><br><br>

        <label for="sleep-score">Current Sleep Score (0-100):</label>
        <input type="number" id="sleep-score" name="sleep_score" min="0" max="100" required><br><br>
        <label for="experiment-factor">Factor to Experiment With:</label>
        <input type="text" id="experiment-factor" name="experiment_factor" required><br><br>
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" name="start_date" required><br><br>
        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" name="end_date" required><br><br>

        <h2>Current Average Sleep Metrics</h2>

        <label for="light-sleep-time">Light Sleep Time (minutes):</label>
        <input type="number" id="light-sleep-time" name="light_sleep_time" min="0" required><br><br>

        <label for="deep-sleep-time">Deep Sleep Time (minutes):</label>
        <input type="number" id="deep-sleep-time" name="deep_sleep_time" min="0" required><br><br>

        <label for="rem-sleep-time">REM Sleep Time (minutes):</label>
        <input type="number" id="rem-sleep-time" name="rem_sleep_time" min="0" required><br><br>

        <label for="awake-time">Awake Time (minutes):</label>
        <input type="number" id="awake-time" name="awake_time" min="0" required><br><br>

        <label for="energy-level">Current Energy Level (1-10):</label>
        <input type="number" id="energy-level" name="energy_level" min="1" max="10" required><br><br>
        <input type="submit" value="Set Up Experiment">
    </form>
    <footer>
        <?php
            include "../serverScripting/includes/navigation/globalFooter.php";
        ?>
    </footer>
</body>
</html>

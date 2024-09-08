<!DOCTYPE html>
<?php

    // Linking to session configuration file and login view file
    require_once "../serverScripting/includes/dbh.inc.php";
    require_once "../serverScripting/includes/config_session.inc.php";
    require_once "../serverScripting/includes/login_view.inc.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Your Stats</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../clientScripting/index.js" defer></script>
</head>
<body id="logStatsPage" class="form">
    <header>
        <?php
            include "../serverScripting/includes/navigation/globalHeader.php";
            include "../serverScripting/includes/experiments/experimentView.inc.php"
        ?>
    </header>
    <h1>Enter Your Daily Sleep Stats</h1>
    <p>Enter your stats from your last sleep. Do this daily for the remainder of your experiment length. Then check the "experiment results" page to see your results.</p>
    <form id="logStats" action="../serverScripting/includes/scores/scores.inc.php" method="post">
        <label for="experiment-name">Please choose your experiment</label>
        <select id="experiment-name" name="experiment_name" required>
        <?php
            output_experiment_names($pdo);
        ?>
        </select>
        <label for="daily-sleep-amount">Sleep Amount (hours):</label>
        <input type="number" id="daily-sleep-amount" name="daily_sleep_amount" min="0" max="24" required><br><br>
        <label for="daily-sleep-score">Sleep Score (0-100):</label>
        <input type="number" id="daily-sleep-score" name="daily_sleep_score" min="0" max="100" required><br><br>
        <label for="daily-time-awake">Time Awake (minutes):</label>
        <input type="number" id="daily-time-awake" name="daily_time_awake" min="0" required><br><br>

        <label for="daily-light-sleep-time">Light Sleep Time (minutes):</label>
        <input type="number" id="daily-light-sleep-time" name="daily_light_sleep_time" min="0" required><br><br>

        <label for="daily-deep-sleep-time">Deep Sleep Time (minutes):</label>
        <input type="number" id="daily-deep-sleep-time" name="daily_deep_sleep_time" min="0" required><br><br>

        <label for="daily-rem-sleep-time">REM Sleep Time (minutes):</label>
        <input type="number" id="daily-rem-sleep-time" name="daily_rem_sleep_time" min="0" required><br><br>

        <label for="daily-energy-level">Energy Level (1-10):</label>
        <input type="number" id="daily-energy-level" name="daily_energy_level" min="1" max="10" required><br><br>
        <input id="submitButton" type="submit" value="Submit Daily Stats">
    </form>
    <footer>
        <?php
            include "../serverScripting/includes/navigation/globalFooter.php";
        ?>
    </footer>
</body>
</html>
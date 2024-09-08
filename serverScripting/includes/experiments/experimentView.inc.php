<?php
include_once 'experimentModel.inc.php';
include(__DIR__.'/../scores/scores_model.inc.php');
include_once __DIR__ . '/../dbh.inc.php';

// Requiring the necessary files   

function output_experiment_names($pdo) {
    if (isset($_SESSION["user_id"]))
    {
        get_experiment_names($pdo, $_SESSION["user_id"]);

        $names = $_SESSION["experimentNames"];

        if (!empty($names)) 
        {
            foreach ($names as $name) {
                echo "<option value='" . $name . "' class='experimentName'>" . $name . "</option>";
            }
        }
        else {
            echo "<option>No experiments started!</option>";
        }
    }
    else 
    {
        echo "<option>No experiments started!</option>";
    }
}

function show_experiment_status($pdo) 
{
    if (isset($_SESSION["user_id"])) 
    {

        // Getting all the experiment start and end dates in an array along with the corresponding experiment names
        $experimentStartAndEndsArray = get_experiment_start_and_end_dates($pdo, $_SESSION["user_id"]);

        if (empty($experimentStartAndEndsArray)) 
        {
            echo "<p>You have not completed any experiments!</p>";
            return;
        }


        // Getting all the experiment lengths, and checking if the experiment has ended. If it has, calculate the averages.
        foreach ($experimentStartAndEndsArray as $experimentStartAndEnd) 
        {
            // Container for experiment details
            echo "<div class='experiment-details'>";
            echo "<h2>Experiment: " . $experimentStartAndEnd['experimentName'] . "</h2>";
            echo "<p>Start Date: " . $experimentStartAndEnd['startDate'] . "</p>";
            echo "<p>End Date: " . $experimentStartAndEnd['endDate'] . "</p>";

            // Getting the specific experiment name
            $experimentName = $experimentStartAndEnd['experimentName'];

            // Getting the start and end dates of the specific experiment
            $startDate = $experimentStartAndEnd['startDate'];
            $endDate = $experimentStartAndEnd['endDate'];

            // Convert the dates to unix timestamps
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            if ($startDate > time()) 
            {
                echo "<p>The experiment has not started yet!</p>";
                continue;
            }
            else if ($endDate < time()) 
            {
                echo "<p>The experiment has ended!</p>";
                continue;
            }
            else if ($startDate <= time() && $endDate >= time()) 
            {
                echo "<p>The experiment is currently running!</p>";

                // Echo days left in the experiment
                echo "<p>Days left in the experiment: " . ($endDate - time()) / 86400 . "</p>";
            }

            // Calculate the length of the experiment
            $experimentLength = ($endDate - time()) / 86400;

            $experimentId = get_experimentId($pdo, $experimentName);


            // Check if the experiment has ended
            if (($experimentLength <= 0) && (check_if_experiment_has_finished($pdo, $experimentId) === '0')) 
            {
                // If the experiment has ended, pass the pdo, user_id, and experiment start and end to the function
                echo "<p>This experiment has ended!</p>";

                calculate_experiment_stat_averages($pdo, $_SESSION["user_id"], $experimentStartAndEnd, $experimentName, $experimentId);
                
            }
            else if (($experimentLength <= 0) && (check_if_experiment_has_finished($pdo, $experimentId) === '1')) 
            {
                echo "<p>This experiment has ended</p>";
                echo "<p>See the results below!</p>";
            }
            else 
            {
                echo "<p>The experiment has not ended!</p>";
            }

            echo "</div>";

        } // Closes the foreach loop

        $allExperimentResults = fetch_experiment_results($pdo, $_SESSION["user_id"]);
        
        if (empty($allExperimentResults) || $allExperimentResults === NULL) 
        {
            echo "<p>You have not completed any experiments!</p>";
            return;
        }
        else 
        {
            // Output the results
            foreach ($allExperimentResults as $experimentResult) {
                // Check if the experiment result is empty. If there is an empty result, skip the process of displaying the result.
                if (empty($experimentResult) || $experimentResult === NULL || $experimentResult['sleepAmountDifference'] === NULL || $experimentResult['sleepScoreDifference'] === NULL || $experimentResult['energyLevelDifference'] === NULL || $experimentResult['timeAwakeDifference'] === NULL || $experimentResult['lightSleepTimeDifference'] === NULL || $experimentResult['deepSleepTimeDifference'] === NULL || $experimentResult['remSleepTimeDifference'] === NULL) 
                {
                    continue;
                }
                echo "<h2>" . $experimentResult['experimentName'] . "</h2>";

                
                echo "<p>Your sleep amount differed by " . ($experimentResult['sleepAmountDifference'] >= 0 ? '+' : '') . $experimentResult['sleepAmountDifference'] . " minutes on average during the experiment</p>";
                echo "<p>Your sleep score differed by " . ($experimentResult['sleepScoreDifference'] >= 0 ? '+' : '') . $experimentResult['sleepScoreDifference'] . " points on average during the experiment</p>";
                echo "<p>Your energy level differed by " . ($experimentResult['energyLevelDifference'] >= 0 ? '+' : '') . $experimentResult['energyLevelDifference'] . " points on average during the experiment</p>";
                echo "<p>Your time awake differed by " . ($experimentResult['timeAwakeDifference'] >= 0 ? '+' : '') . $experimentResult['timeAwakeDifference'] . " minutes on average during the experiment</p>";
                echo "<p>Your light sleep time differed by " . ($experimentResult['lightSleepTimeDifference'] >= 0 ? '+' : '') . $experimentResult['lightSleepTimeDifference'] . " minutes on average during the experiment</p>";
                echo "<p>Your deep sleep time differed by " . ($experimentResult['deepSleepTimeDifference'] >= 0 ? '+' : '') . $experimentResult['deepSleepTimeDifference'] . " minutes on average during the experiment</p>";
                echo "<p>Your rem sleep time differed by " . ($experimentResult['remSleepTimeDifference'] >= 0 ? '+' : '') . $experimentResult['remSleepTimeDifference'] . " minutes on average during the experiment</p>";
            }
        }
    }
    else 
    {
        echo "<p>Please log in to view your experiment results</p>";
        echo "<br>";
        echo "<a id='login-cta' href='login.php'>Login</a>";
    }
    
} // Closes the function

function check_if_logged_in() {
    if (!isset($_SESSION["user_id"])) {
       echo "<p>Please log in or create an account to setup an experiment</p>";
    }
}

function outputErros() {
    if (isset($_SESSION["errors_experiment"])) {
        $errors = $_SESSION["errors_experiment"];
        foreach ($errors as $error) {
            echo "<p>" . $error . "</p>";
        }
    }
}


?>
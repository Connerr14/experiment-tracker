<?php
    // Show all php errors on page
    ini_set('display_errors', '1');
    session_start();


    
    if ($_SERVER["REQUEST_METHOD"] === "POST")  {
        require_once '../dbh.inc.php';
        require_once 'scores_model.inc.php';
        require_once 'scores_controller.inc.php';
        require '../experiments/experimentModel.inc.php';



        // Getting the data from the form
        $experimentName = $_POST['experiment_name'];

        $sleepAmount = $_POST['daily_sleep_amount'];
        $sleepScore = $_POST['daily_sleep_score'];
        $timeAwake = $_POST['daily_time_awake'];
        $lightSleepTime = $_POST['daily_light_sleep_time'];
        $deepSleepTime = $_POST['daily_deep_sleep_time'];
        $remSleepTime = $_POST['daily_rem_sleep_time'];
        $energyLevel = $_POST['daily_energy_level'];

        // Creating a new array to store errors
        $statErrors = [];

        // Checking if the input is empty
        if (isInputEmpty($experimentName, $sleepAmount, $sleepScore, $timeAwake, $lightSleepTime, $deepSleepTime, $remSleepTime, $energyLevel)) {
            $statErrors['empty_input'] = 'Please fill in all fields!';
        }

        // Checking if the input is invalid
        if (isInputInvalid($sleepAmount, $sleepScore, $timeAwake, $lightSleepTime, $deepSleepTime, $remSleepTime, $energyLevel)) {
            $statErrors['invalid_input'] = 'Please enter valid input!';
        }

        // Checking if there are any errors
        if ($statErrors) {
            $errors = $statErrors;
            foreach ($errors as $error) {
                echo $error;
            }
            die();
        }

        // Storing the data in the database
        storeScoresData($pdo, get_experimentId($pdo, $experimentName), $sleepAmount, $sleepScore, $timeAwake, $lightSleepTime, $deepSleepTime, $remSleepTime, $energyLevel);

        header("Location: ../../../structure/statsLogged.php");
    }
    else {
        header("Location: ../../../structure/index.php");
    }

?>
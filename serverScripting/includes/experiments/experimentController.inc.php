<?php
// Getting the configuration file so that a users metrics can be stored in the database using the correct id
include_once '../config_session.inc.php';
include_once '../scores/scores_model.inc.php';
include_once '../experiments/experimentModel.inc.php';

session_start();

// The file to do the error checking for the inputs from the user

// A function to check if the input is empty
function isSleepInputEmpty($sleepAmount, $sleepScore, $experimentFactor, $startDate, $endDate, $lightSleepTime, $deepSleepTime, $remSleepTime, $awakeTime, $energyLevel) {
    if (empty($sleepAmount) || empty($sleepScore) || empty($experimentFactor) || empty($startDate) || empty($endDate) || empty($lightSleepTime) || empty($deepSleepTime) || empty($remSleepTime) || empty($awakeTime) || empty($energyLevel)) {
        return true;
    }
    else {
        return false;
    }
}

// A function to check if the input is invalid
function isSleepInputInvalid($sleepAmount, $sleepScore, $experimentFactor, $startDate, $endDate, $lightSleepTime, $deepSleepTime, $remSleepTime, $awakeTime, $energyLevel) {
    if (!is_numeric($sleepAmount) || !is_numeric($sleepScore) || !is_string($experimentFactor) || !is_string($startDate) || !is_string($endDate) || !is_numeric($lightSleepTime) || !is_numeric($deepSleepTime) || !is_numeric($remSleepTime) || !is_numeric($awakeTime) || !is_numeric($energyLevel)) {
        return true;
    }
    else {
        return false;
    }
}


// A function to check if the experiment factor is invalid 
function isExperimentFactorInvalid ($experimentFactor) {
    if (strlen($experimentFactor) < 1 || strlen($experimentFactor) > 200) {
        return true;
    }
    else {
        return false;
    }
}

function does_user_have_an_experiment_with_that_name($pdo, $experiment_name) {
    $usersExistingExperimentNames = get_experiment_names($pdo, $_SESSION["user_id"]);

    foreach ($_SESSION["experimentNames"]  as $currentExperimentName) {
        if ($currentExperimentName == $experiment_name) {
            return true;
        } 
    }
    return false;
}


?>

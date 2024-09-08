<?php
// Outputting the errors
ini_set('display_errors', 1);

// Requiring the necessary files
require_once '../config_session.inc.php';
require_once '../dbh.inc.php';
require_once 'experimentModel.inc.php';
require_once 'experimentController.inc.php';


try 
{

    // Checking that the form was submitted via POST
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])) 
    {
        // Getting the data from the form
        $experiment_name = $_POST["experiment_name"];
        $sleep_amount = $_POST["sleep_amount"];
        $sleep_score = $_POST["sleep_score"];
        $experiment_factor = $_POST["experiment_factor"];
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $light_sleep_time = $_POST["light_sleep_time"];
        $deep_sleep_time = $_POST["deep_sleep_time"];
        $rem_sleep_time = $_POST["rem_sleep_time"];
        $awake_time = $_POST["awake_time"];
        $energy_level = $_POST["energy_level"];

        // Creating a new array to store errors
        $errors = [];


        // Checking if the input is empty
        if (isSleepInputEmpty($sleep_amount, $sleep_score, $experiment_factor, $start_date, $end_date, $light_sleep_time, $deep_sleep_time, $rem_sleep_time, $awake_time, $energy_level)) {
            $errors["empty_input"] = 'Please fill in all fields!';
        }

        // Checking if the input is invalid
        if (isSleepInputInvalid($sleep_amount, $sleep_score, $experiment_factor, $start_date, $end_date, $light_sleep_time, $deep_sleep_time, $rem_sleep_time, $awake_time, $energy_level)) {
            $errors["invalid_input"] = 'Please enter valid input!';
        }


        // Checking if the experiment factor is invalid
        if (isExperimentFactorInvalid($experiment_factor)) {
            $errors["invalid_experiment_factor"] = 'Please enter a valid experiment factor!';
        }

        // Checking for a truthy value
        if (does_user_have_an_experiment_with_that_name($pdo, $experiment_name)) {
            $errors["duplicate_experiment_name"] = "You have already used that experiment name. Please choose a different one.";
        }


        // Checking if there are any errors
        if ($errors) {
            $_SESSION["errors_experiment"] = $errors;
            header("Location: ../../../structure/setup.php");
            die();
        }
        else {
        // Storing the experiment data in the database
        storeExperimentData($pdo, $_SESSION["user_id"], $experiment_name, $sleep_amount, $sleep_score, $experiment_factor, $start_date, $end_date, $light_sleep_time, $deep_sleep_time, $rem_sleep_time, $awake_time, $energy_level);

        header("Location: ../../../structure/statsLogged.php");
        }
    }

    else 
    {
        header("Location: ../../../structure/setup.php");
    } 
}
catch (Exception $e) 
{
    echo "Error: " . $e->getMessage();
}
?>
<?php
include_once '../dbh.inc.php';
include_once '../scores/scores_model.inc.php';

    // A function to store Experiment Data
    function storeExperimentData($pdo, $user_id, $experiment_name, $sleep_amount, $sleep_score, $experiment_factor, $start_date, $end_date, $light_sleep_time, $deep_sleep_time, $rem_sleep_time, $awake_time, $energy_level) {
        try {
            // Begin transaction
            if (!$pdo->inTransaction()) {
                $pdo->beginTransaction();
            }

            // Preparing the SQL statement
            $experimentDataQuery = "INSERT INTO experiment (experimentName, experimentFactor, userId, startDate, endDate) VALUES (:experiment_name, :experiment_factor, :user_id, :start_date, :end_date)";

            $stmt = $pdo->prepare($experimentDataQuery);

            $stmt->execute([
                ':experiment_name' => $experiment_name,
                ':experiment_factor' => $experiment_factor,
                ':user_id' => $user_id,
                ':start_date' => $start_date,
                ':end_date' => $end_date
            ]);



            // Get the last inserted experimentId
            $experimentId = $pdo->lastInsertId();

            $_SESSION["experimentId"] = $experimentId;

            // Entering the current stats for the experiment (average of the last while)
            $sleepStatsQuery = "INSERT INTO currentStat (experimentId, currentSleepAmount, currentSleepScore, currentLightSleep, currentDeepSleep, currentRemSleep, currentAwakeTime, currentEnergyLevel) VALUES (:experimentId, :sleep_amount, :sleep_score, :light_sleep_time, :deep_sleep_time, :rem_sleep_time, :awake_time,:energy_level)";

            $stmt = $pdo->prepare($sleepStatsQuery);

            $stmt->execute([
                ':experimentId' => $experimentId,
                ':sleep_amount' => $sleep_amount,
                ':sleep_score' => $sleep_score,
                ':light_sleep_time' => $light_sleep_time,
                ':deep_sleep_time' => $deep_sleep_time,
                ':rem_sleep_time' => $rem_sleep_time,
                ':awake_time' => $awake_time, 
                ':energy_level' => $energy_level
            ]);

            // Commit transaction
            $pdo->commit();

        } catch (Exception $e) {
            // Rollback transaction
            $pdo->rollBack();
            throw $e;
        }
    }

    function get_experiment_names ($pdo, $user_id) {
        try {
            if (!$pdo->inTransaction())
            {
                $pdo->beginTransaction();
            }

            $experimentNamesQuery = "SELECT experimentName FROM experiment WHERE userId = :user_id";
            
            $stmt = $pdo->prepare($experimentNamesQuery);

            $stmt->bindParam(':user_id', $user_id);

            $stmt->execute();

            $experimentNamesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Extracting the 'experimentName' values
            $experimentNamesArray = array_column($experimentNamesArray, 'experimentName');

            $_SESSION["experimentNames"] = $experimentNamesArray;

            return;

        }
        catch (Exception $e) {
            return "Error: " . $e->getMessage();

        }

    }

    function get_experiment_start_and_end_dates($pdo, $user_id) {
        try {
        $pdo->beginTransaction();

        $experimentLengthQuery = "SELECT startDate, endDate, experimentName FROM experiment WHERE userId = :user_id";

        $stmt = $pdo->prepare($experimentLengthQuery);

        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        $experimentStartAndEnd = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Returning all experiment start and end dates along with the corresponding experiment names
        return $experimentStartAndEnd;
        }
        catch (Exception $e) {
            return "Error: " . $e->getMessage();    
        }

    }

    // I now have the averages. I just need to update the db to have a column checking if the experiment has finished. I also need a column to save the results of the experiment. Need to add a check like this,  && experimentHasNotBeenCalculated($pdo, $_SESSION["user_id"], $experimentLength)
    
    function calculate_experiment_stat_averages($pdo, $user_id, $experimentStartAndEnd, $experimentName, $experimentId) 
    {

        try 
        {

            // Getting the start and end dates of the specific experiment
            $startDate = $experimentStartAndEnd['startDate'];
            $endDate = $experimentStartAndEnd['endDate'];


            // -----------------------------------------------------------------
            $pdo->beginTransaction();

            // Getting all the daily sleep stats for the specific experiment
            $dailySleepStatsQuery = "SELECT * FROM dailySleepStat WHERE experimentId = :experiment_id";

            $stmt = $pdo->prepare($dailySleepStatsQuery);

            $stmt->bindParam(':experiment_id', $experimentId);

            $stmt->execute();

            $dailySleepStatsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);


                // Extracting the individual values from the dailySleepStatsArray into its own single dimensional array for each value
                $sleepAmounts = array_column($dailySleepStatsArray, 'sleepAmount') ?: [];
                $sleepScores = array_column($dailySleepStatsArray, 'sleepScore') ?: [];
                $timeAwakes = array_column($dailySleepStatsArray, 'timeAwake') ?: [];
                $lightSleepTimes = array_column($dailySleepStatsArray, 'lightSleepTime') ?: [];
                $deepSleepTimes = array_column($dailySleepStatsArray, 'deepSleepTime') ?: [];
                $remSleepTimes = array_column($dailySleepStatsArray, 'remSleepTime') ?: [];
                $energyLevels = array_column($dailySleepStatsArray, 'energyLevel') ?: [];

                

                $_SESSION["dailySleepStatsArray"] = $dailySleepStatsArray;


                // Calculate the averages
                $averageSleepAmount = !empty($sleepAmounts) ? array_sum($sleepAmounts) / count($sleepAmounts) : 0;
                $averageSleepScore = !empty($sleepScores) ? array_sum($sleepScores) / count($sleepScores) : 0;
                $averageTimeAwake = !empty($timeAwakes) ? array_sum($timeAwakes) / count($timeAwakes) : 0;
                $averageLightSleepTime = !empty($lightSleepTimes) ? array_sum($lightSleepTimes) / count($lightSleepTimes) : 0;
                $averageDeepSleepTime = !empty($deepSleepTimes) ? array_sum($deepSleepTimes) / count($deepSleepTimes) : 0;
                $averageRemSleepTime = !empty($remSleepTimes) ? array_sum($remSleepTimes) / count($remSleepTimes) : 0;
                $averageEnergyLevel = !empty($energyLevels) ? array_sum($energyLevels) / count($energyLevels) : 0;


                // --------------------------------------------------

                echo $experimentId;

                // Get the initial stats for the experiment from the db
                $initialStatsArray = fetchInitialStats($pdo, $experimentId);



                // --------------------------------------------------

                // Calculate the difference between the initial stats and the average stats

                    $sleepAmountDifference = $averageSleepAmount - $initialStatsArray['currentSleepAmount'];
                    $sleepScoreDifference = $averageSleepScore - $initialStatsArray['currentSleepScore'];
                    $timeAwakeDifference = $averageTimeAwake - $initialStatsArray['currentAwakeTime'];
                    $lightSleepTimeDifference = $averageLightSleepTime - $initialStatsArray['currentLightSleep'];
                    $deepSleepTimeDifference = $averageDeepSleepTime - $initialStatsArray['currentDeepSleep'];
                    $remSleepTimeDifference = $averageRemSleepTime - $initialStatsArray['currentRemSleep'];
                    $energyLevelDifference = $averageEnergyLevel - $initialStatsArray['currentEnergyLevel'];

                    // --------------------------------------------------

                    storeExperimentResults($pdo, $user_id, $experimentId, $sleepAmountDifference, $sleepScoreDifference, $timeAwakeDifference, $lightSleepTimeDifference, $deepSleepTimeDifference, $remSleepTimeDifference, $energyLevelDifference);


        }
        catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    function storeExperimentResults($pdo, $user_id, $experimentId, $sleepAmountDifference, $sleepScoreDifference, $timeAwakeDifference, $lightSleepTimeDifference, $deepSleepTimeDifference, $remSleepTimeDifference, $energyLevelDifference) {
       try {
        // Store the results of the experiment in the db
        if (!$pdo->inTransaction())
        {
            $pdo->beginTransaction();
        }

        $experimentResultsQuery = "UPDATE experiment SET sleepAmountDifference = :sleep_amount_difference,  sleepScoreDifference = :sleep_score_difference, timeAwakeDifference = :time_awake_difference, lightSleepTimeDifference = :light_sleep_time_difference,  deepSleepTimeDifference = :deep_sleep_time_difference, remSleepTimeDifference = :rem_sleep_time_difference, energyLevelDifference = :energy_level_difference WHERE experimentId = :experiment_id";
        

        $stmt = $pdo->prepare($experimentResultsQuery);

        $stmt->execute([
            ':experiment_id' => $experimentId,
            ':sleep_amount_difference' => $sleepAmountDifference,
            ':sleep_score_difference' => $sleepScoreDifference,
            ':time_awake_difference' => $timeAwakeDifference,
            ':light_sleep_time_difference' => $lightSleepTimeDifference,
            ':deep_sleep_time_difference' => $deepSleepTimeDifference,
            ':rem_sleep_time_difference' => $remSleepTimeDifference,
            ':energy_level_difference' => $energyLevelDifference
        ]);

        $experimentFinishedQuery = "UPDATE experiment SET experimentFinished = '1' WHERE experimentId = :experiment_id";

        $stmt = $pdo->prepare($experimentFinishedQuery);

        $stmt->execute([
            ':experiment_id' => $experimentId
        ]);

        $pdo->commit();

        return;
    }
    catch (Exception $e) {
        // rollback transaction
        $pdo->rollBack();
        return "Error: " . $e->getMessage();
    }
}

    

    function fetch_experiment_results($pdo, $userId) {
        // Gets the results from the db experiment table

        if (!$pdo->inTransaction())
        {
            $pdo->beginTransaction();
        }

        $experimentResultsQuery = "SELECT experimentName, sleepAmountDifference, sleepScoreDifference, timeAwakeDifference, lightSleepTimeDifference, deepSleepTimeDifference, remSleepTimeDifference, energyLevelDifference FROM experiment WHERE userId = :user_id";

        $stmt = $pdo->prepare($experimentResultsQuery);

        $stmt->bindParam(':user_id', $userId);

        $stmt->execute();

        $experimentResultsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $experimentResultsArray;
    }

    function fetchInitialStats($pdo, $experimentId) {
        $query = "SELECT * FROM currentStat WHERE experimentId = :experiment_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':experiment_id', $experimentId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function check_if_experiment_has_finished ($pdo, $experimentId) {
        $query = "SELECT experimentFinished FROM experiment WHERE experimentId = :experiment_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':experiment_id', $experimentId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['experimentFinished'];
    }
        
?>
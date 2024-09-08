<?php

    function get_experimentId($pdo, $experimentName) {
        // Begin transaction
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        // Preparing the SQL statement
        $experimentIdQuery = "SELECT experimentId FROM experiment WHERE experimentName = :experiment_name AND userId = :user_id";

        $stmt = $pdo->prepare($experimentIdQuery);

        $stmt->execute([
            ':experiment_name' => $experimentName,
            ':user_id' => $_SESSION["user_id"]
        ]);

        $firstRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $experimentId = $firstRow['experimentId'];

        // Commit transaction
        $pdo->commit();

        return $experimentId;
    }

    function storeScoresData($pdo, $experimentId, $sleepAmount, $sleepScore, $timeAwake, $lightSleepTime, $deepSleepTime, $remSleepTime, $energyLevel) {
        try {
            // Begin transaction
            $pdo->beginTransaction();

            // Preparing the SQL statement
            $scoresDataQuery = "INSERT INTO dailySleepStat (experimentId, sleepAmount, sleepScore, timeAwake, lightSleepTime, deepSleepTime, remSleepTime, energyLevel) VALUES (:experiment_id, :daily_sleep_amount, :daily_sleep_score, :daily_time_awake, :daily_light_sleep_time, :daily_deep_sleep_time, :daily_rem_sleep_time, :daily_energy_level)";

            $stmt = $pdo->prepare($scoresDataQuery);

            $stmt->execute([
                ':experiment_id' => $experimentId,
                ':daily_sleep_amount' => $sleepAmount,
                ':daily_sleep_score' => $sleepScore,
                ':daily_time_awake' => $timeAwake,
                ':daily_light_sleep_time' => $lightSleepTime,
                ':daily_deep_sleep_time' => $deepSleepTime,
                ':daily_rem_sleep_time' => $remSleepTime,
                ':daily_energy_level' => $energyLevel
            ]);

            // Commit transaction
            $pdo->commit();

        } catch (Exception $e) {
            // Rollback transaction
            $pdo->rollBack();
            throw $e;
        }
    }


?>
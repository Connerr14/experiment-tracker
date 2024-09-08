<?php
    function isInputEmpty () {
        if (empty($_POST['experiment_name']) || empty($_POST['daily_sleep_amount']) || empty($_POST['daily_sleep_score']) || empty($_POST['daily_time_awake']) || empty($_POST['daily_light_sleep_time']) || empty($_POST['daily_deep_sleep_time']) || empty($_POST['daily_rem_sleep_time']) || empty($_POST['daily_energy_level'])) {
            return true;
        }
        return false;
    }

    function isInputInvalid () {
        if ($_POST['daily_sleep_amount'] < 0 || $_POST['daily_sleep_amount'] > 24 || $_POST['daily_sleep_score'] < 0 || $_POST['daily_sleep_score'] > 100 || $_POST['daily_time_awake'] < 0 || $_POST['daily_light_sleep_time'] < 0 || $_POST['daily_deep_sleep_time'] < 0 || $_POST['daily_rem_sleep_time'] < 0 || $_POST['daily_energy_level'] < 0 || $_POST['daily_energy_level'] > 10) {
            return true;
        }
        return false;
    }



?>
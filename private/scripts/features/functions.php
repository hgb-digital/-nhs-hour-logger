<?php

function get_error_names($errors) {
    $json_error_messages = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/error_text.json");
    $error_messages = json_decode($json_error_messages, true);
    
    $return = [];
    foreach ($errors as $error) {
        $return[] = array_key_exists($error, $error_messages) ? $error_messages[$error] : $error_messages['internal_server'];
    }
    unset($_SESSION['form_errors']);

    return $return;
}

function check_empty(array $args) {
    foreach ($args as $value) {
        if (empty($value)) {
            return true;
        }
    }
    return false;
}

function display_form_errors($success_message = null) {
    if (isset($_SESSION["form_errors"])) {
        $messages = get_error_names($_SESSION['form_errors']);
        
        foreach ($messages as $msg) {
            echo '<p class="form-error">' . $msg . '</p>';
            echo "<br>";
        }

    }
    else if (isset($_GET['result']) && $_GET['result'] === "success") {
        if (!($success_message === null)) {
            if (!($success_message == "")) {
                echo '<p class="form-success">' . $success_message . '</p>';
            }
        } else {
            echo '<p class="form-success">Success!</p>';
        }
        echo '<br>';
    }
}

function get_chapter_stats() {
    $officer_hours_isp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'officer' AND hours.type = 'isp';")[0]['total_hours'] ?? 0;

    $officer_hours_gsp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'officer' AND hours.type = 'gsp';")[0]['total_hours'] ?? 0;

    $polis_hours_isp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'polis' AND hours.type = 'isp';")[0]['total_hours'] ?? 0;

    $polis_hours_gsp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'polis' AND hours.type = 'gsp';")[0]['total_hours'] ?? 0;

    $elders_hours_isp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'elders' AND hours.type = 'isp';")[0]['total_hours'] ?? 0;

    $elders_hours_gsp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'elders' AND hours.type = 'gsp';")[0]['total_hours'] ?? 0;

    $fundraiser_hours_isp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'fundraiser' AND hours.type = 'isp';")[0]['total_hours'] ?? 0;

    $fundraiser_hours_gsp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'fundraiser' AND hours.type = 'gsp';")[0]['total_hours'] ?? 0;

    $assembly_hours_isp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'assembly' AND hours.type = 'isp';")[0]['total_hours'] ?? 0;

    $assembly_hours_gsp = run_query("SELECT
        SUM(hours.duration) as total_hours
        FROM hours
        JOIN users ON hours.user_id = users.id
        WHERE users.committee = 'assembly' AND hours.type = 'gsp';")[0]['total_hours'] ?? 0;
    
    return [
        'officer' => ['isp' => $officer_hours_isp, 'gsp' => $officer_hours_gsp],
        'polis' => ['isp' => $polis_hours_isp, 'gsp' => $polis_hours_gsp],
        'elders' => ['isp' => $elders_hours_isp, 'gsp' => $elders_hours_gsp],
        'fundraiser' => ['isp' => $fundraiser_hours_isp, 'gsp' => $fundraiser_hours_gsp],
        'assembly' => ['isp' => $assembly_hours_isp, 'gsp' => $assembly_hours_gsp]
    ];
}
<?php

function log_hours($data) {
    require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");

    $type = 'isp';
    if (isset($data['gsp'])) {
        $type = 'gsp';
        if (!isset($data['hours'])) {
            return ['errors' => ['empty_input']];
        }
        $hours = $data['hours'];
    } else {
        $title = $data["title"] ?? null;
        $description = $data["description"] ?? null;
        $supervisor_name = $data["supervisor_name"] ?? null;
        $supervisor_contact = $data["supervisor_contact"] ?? null;
        $hours = $data["hours"] ?? null;

        if (check_empty([$type, $title, $description, $supervisor_name, $supervisor_contact, $hours])) {
            return ['errors' => ['empty_input']];
        }
        if (!in_array($type, ['gsp', 'isp'])) {
            return ['errors' => ['invalid_type']];
        }
    }

    if (!is_numeric($hours) || floatval($hours) <= 0) {
        return ['errors' => ['internal_server']];
    }

    //add a condition to make sure gsp roles haven't already been logged
    if ($type === 'gsp') {
        $gsp_logged = run_query("SELECT role_id FROM hours where user_id = :user_id AND role_id = :role_id;", [
            ':user_id' => $_SESSION['user_id'],
            ':role_id' => $data['gsp']
        ]);
        if (!empty($gsp_logged)) {
            return ['errors' => ['internal_server']];
        }

        run_query("INSERT INTO hours (user_id, type, role_id, duration) VALUES (:user_id, 'gsp', :role_id, :duration);", [
            ':user_id' => $data['user_id'],
            ':role_id' => $data['gsp'],
            ':duration' => floatval($hours)
        ]);

        return true;

    }

    run_query("INSERT INTO hours (user_id, type, title, description, supervisor_name, supervisor_contact, duration) VALUES (:user_id, :type, :title, :description, :supervisor_name, :supervisor_contact, :duration);", [
        ':user_id' => $_SESSION['user_id'],
        ':type' => $type,
        ':title' => $title,
        ':description' => $description,
        ':supervisor_name' => $supervisor_name,
        ':supervisor_contact' => $supervisor_contact,
        ':duration' => floatval($hours)
    ]);

    return true;
}
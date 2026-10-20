<?php

function edit_hour($data) {
    if (!isset($data['edit']) || !isset($data['hour_id']) || !in_array($data['edit'], ['delete'])) {
        return ['errors' => ['empty_input']];
    }

    $hour_id = intval($data['hour_id']);
    $hour_user_id = run_query("SELECT user_id FROM hours WHERE id = :id;", [':id' => $hour_id])[0]['user_id'] ?? null;
    if (!$hour_user_id) {
        return ['errors' => ['internal_server']];
    }
    if (!(($_SESSION['user_permissions'] == 'admin') || ($_SESSION['user_title'] == "parliamentarian"))) {
        if ($hour_user_id != $_SESSION['user_id']) {
            return ['errors' => ['internal_server']];
        }
    }

    if ($data['edit'] == 'delete') {
        run_query("DELETE FROM hours WHERE id = :id;", [':id' => $hour_id]);
    }

    return true;


}
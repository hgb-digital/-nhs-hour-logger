<?php

function create_service ($data) {
    if (check_empty([$data['title'], $data['description'], $data['role_count']])) {
        return ['errors' => ['empty_input']];
    }
    
    //check to make sure role count and role data match
    $role_count = intval($data['role_count']);
    for ($i = 1; $i <= $role_count; $i++) {
        if (check_empty([$data["role_{$i}_title"], $data["role_{$i}_desc"], $data["role_{$i}_slots"], $data["role_{$i}_time"], $data["role_{$i}_loc"]])) {
            return ['errors' => ['empty_input']];
        }
        
        $timestamp = date('Y-m-d H:i:s', strtotime($data["role_{$i}_time"]));
        if ($timestamp < date('Y-m-d H:i:s')) {
            return ['errors' => ['internal_server']];
        }
    }

    run_query("INSERT INTO service_sheet (title, description, organizer_id) VALUES (:title, :description, :id);", [
        ':title' => $data['title'],
        ':description' => $data['description'],
        ':id' => $_SESSION['user_id'],
    ]);

    $sheet_id = run_query("SELECT LAST_INSERT_ID() as id;")[0]['id'];

    for ($i = 1; $i <= $role_count; $i++) {
        if (!isset($data["role_{$i}_attire"]) || $data["role_{$i}_attire"] === '') {
            $data["role_{$i}_attire"] = null;
        }
        run_query("INSERT INTO service_roles (sheet_id, description, slots, time, location, attire) VALUES (:s, :d, :slots, :t, :l, :a);", [
            ':s' => $sheet_id,
            ':d' => $data["role_{$i}_desc"],
            ':slots' => $data["role_{$i}_slots"],
            ':t' => $data["role_{$i}_time"],
            ':l' => $data["role_{$i}_loc"],
            ':a' => $data["role_{$i}_attire"]
        ]);
    }

    return true;

}
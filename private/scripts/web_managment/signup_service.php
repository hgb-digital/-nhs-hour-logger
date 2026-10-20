<?php

function signup_service($data) {
    $role_id = $data['role_id'] ?? null;
    $user_id = $data['user_id'] ?? null;

    //add or remove
    $request = $data['type'] ?? null;

    if (!$role_id || !$user_id || !$request) {
        return ['errors' => ['empty_input']];
    }

    if ($request == "add") {
        $check = run_query("SELECT id FROM signups WHERE user_id = :user_id AND role_id = :role_id;", [':user_id' => $user_id, ':role_id' => $role_id])[0] ?? null;
        if ($check) {
            return ['errors' => ['internal_server']];
        }

        run_query("INSERT INTO signups (user_id, role_id) VALUES (:user_id, :role_id);", [':user_id' => $user_id, ':role_id' => $role_id]);
    } else if ($request == "remove") {
        run_query("DELETE FROM signups WHERE user_id = :user_id AND role_id = :role_id;", [':user_id' => $user_id, ':role_id' => $role_id]);
    } else {
        return ['errors' => ['internal_server']];
    }

    return true;

}
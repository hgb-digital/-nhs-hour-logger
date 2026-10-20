<?php

declare(strict_types=1);

function set_user(string $first_name, string $last_name, string $pwd, string $email, string $grad_year) {
    $options = [
        'cost' => 12
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    // default permissions = 1 (standard user)
    run_query("INSERT INTO users (first_name, last_name, password, email, graduation_year, permissions) VALUES (:first_name, :last_name, :pwd, :email, :grad_year, :permissions)", [
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':pwd' => $hashedPwd,
        ':email' => $email,
        ':grad_year' => $grad_year,
        ':permissions' => 1
    ]);

    require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");
    $user_id = run_query("SELECT LAST_INSERT_ID() as id;")[0]["id"];
    if (function_exists('obtain_achievement')) {
        obtain_achievement(1, $user_id);
    }
}

function create_user(string $first_name, string $last_name, string $pwd, string $email, string $grad_year) {
    set_user($first_name, $last_name, $pwd, $email, $grad_year);
}
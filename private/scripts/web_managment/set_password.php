<?php

function set_password($data) {
    $token = $data['token'] ?? '';
    $password = $data['password'] ?? '';
    $confirm_password = $data['confirm-password'] ?? '';

    if (!$token || !$password || !$confirm_password) {
        return ['errors' => ['empty_input']];
    }

    if ($password !== $confirm_password) {
        return ['errors' => ['password_mismatch']];
    }

    require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/login/email_verification.php");
    require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");

    $token_query = run_query("SELECT user_id, type, expires FROM email_verification WHERE token = :t;", [':t' => $token])[0] ?? null;
    if (!$token_query) {
        return ['errors' => ['invalid_token']];
    }

    if ($token_query['type'] !== "verify_email") {
        return ['errors' => ['invalid_token']];
    }

    if (new DateTime() > new DateTime($token_query['expires'])) {
        return ['errors' => ['internal_server']];
    }

    // set the new password
    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($password, PASSWORD_BCRYPT, $options);
    run_query("UPDATE users SET password = :pwd WHERE id = :id;", [':pwd' => $hashedPwd, ':id' => $token_query['user_id']]);
    
    // delete the token
    run_query("DELETE FROM email_verification WHERE token = :t;", [':t' => $token]);

    return true;
}
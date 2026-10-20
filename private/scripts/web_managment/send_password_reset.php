<?php

function send_password_reset($data) {
    if (!isset($data['email'])) {
        return ['errors' => ['empty_input']];
    }

    run_query("UPDATE users SET password = NULL WHERE email = :email;", [":email" => $data['email']]);
    require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/scripts/login/email_verification.php');
    if (!send_verification($data['email'], true)) {
        return ['errors' => ['internal_server']];
    }

    return true;
}
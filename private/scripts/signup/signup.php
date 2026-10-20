<?php

function signup($data) {

    $email = trim($data["email"] ?? '');

    try {
        require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/signup/signup_setget.php");
        require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");
        require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/login/email_verification.php");

        $errors = [];

        if (check_empty([$email])) {
            $errors[] = "empty_input";
        }

        $user = run_query("SELECT password FROM users WHERE email = :email;", [":email" => $email])[0] ?? null;
        if (!$user) {
            $errors[] = "email_not_found";
        }
        if ($user["password"]) {
            $errors[] = "account_verified";
        }

        
        if ($errors) {
            return ['errors' => $errors];
        }
        $user_id = run_query("SELECT id FROM users WHERE email = :email;", [":email" => $email])[0]['id'] ?? null;
        $request = run_query("SELECT expires FROM email_verification WHERE user_id = :id AND type = 'verify_email';", [":id" => $user_id])[0] ?? null;
        if ($request && new DateTime() < new DateTime($request['expires'])) {
            return ['errors' => ['request_valid']];
        }

        // sent verification email
        if (!send_verification($email)) {
            return ['errors' => ['internal_server']];
        }

        return true;

    } catch (PDOException $e) {
        error_log('Signup error: ' . $e->getMessage());
        return ['errors' => ['internal_server']];
    }

}
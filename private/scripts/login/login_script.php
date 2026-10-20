<?php
function login($data) {
    try {
        $email = trim($data['email'] ?? '');
        $pwd = $data['pwd'] ?? '';

        require_once 'login_get.php';
        require_once 'login_check.php';
        require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");

        $errors = [];

        if (check_empty([$email, $pwd])) {
            return ['errors' => ['empty_input']];
        }

        $result = get_user_by_email($email);
        if (!$result) {
            $errors[] = "email_not_found";
        }
        if ($result && !$result['password']) {
            $errors[] = "account_not_verified";
        }

        if (!$errors && is_password_wrong($pwd, $result["password"])) {
            $errors[] = "login_incorrect";
        }


        $authorized = isset($result['committee']);
        if (!$authorized) {
            $errors[] = 'no_committee';
        }

        if ($errors) {
            return ['errors' => $errors];
        }

        require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/config_session.php");

        // Stronger session handling
        session_regenerate_id(true);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_email"] = htmlspecialchars($result["email"] ?? $email, ENT_QUOTES, 'UTF-8');
        $_SESSION["user_first_name"] = htmlspecialchars($result["first_name"] ?? '', ENT_QUOTES, 'UTF-8');
        $_SESSION["user_last_name"] = htmlspecialchars($result["last_name"] ?? '', ENT_QUOTES, 'UTF-8');
        $_SESSION["user_year"] = htmlspecialchars($result["graduation_year"] ?? '', ENT_QUOTES, 'UTF-8');
        // maintain legacy `user_username` for places that still reference it
        $displayName = trim(($result['first_name'] ?? '') . ' ' . ($result['last_name'] ?? ''));
        if (!empty($displayName)) {
            $_SESSION['user_username'] = htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8');
        } else {
            // derive a safe username from email local-part
            $local = explode('@', $_SESSION["user_email"])[0];
            $_SESSION['user_username'] = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $local);
        }

        $_SESSION["user_permissions"] = $result["permissions"];
        // include title and committee as requested
        $_SESSION["user_title"] = $result["title"] ?? null;
        $_SESSION["user_committee"] = $result["committee"] ?? null;

        $_SESSION["last_regeneration"] = time();

        return true;

    } catch (PDOException $e) {
        error_log('Login error: ' . $e->getMessage());
        return ['errors' => ['internal_server']];
    }

}
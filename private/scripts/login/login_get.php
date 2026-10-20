<?php

declare(strict_types=1);

function get_user_by_email(string $email) {
    $result = run_query("SELECT * FROM users WHERE email = :email;", [':email' => $email]);
    if (empty($result)) {
        return false;
    }
    return $result[0];
}
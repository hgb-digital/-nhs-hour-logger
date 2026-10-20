<?php

declare(strict_types=1);

function output_username() {
    if(isset($_SESSION["user_id"])) {
        $name = trim(($_SESSION['user_first_name'] ?? '') . ' ' . ($_SESSION['user_last_name'] ?? ''));
        if (empty($name)) {
            $name = $_SESSION['user_email'] ?? $_SESSION['user_username'] ?? 'user';
        }
        echo "You are logged in as " . $name . "  - PERMISSION: " . ($_SESSION['user_permissions'] ?? '');
    } else {
        echo "You are not logged in";
    }
}
<?php

declare(strict_types=1);


function is_password_wrong(string $result, string $hashedpwd) {
    if (!password_verify($result, $hashedpwd)) {
        return true;
    } else {
        return false;
    }
}
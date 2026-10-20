<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_email($subject, $body, $send_to) {
    $api_key = "{INSERT API KEY}"; // store your key in env variables
    if (!$api_key) {
        error_log("SMTP2GO API key not set");
        return false;
    }

    $data = [
        "api_key" => $api_key,
        "to" => [$send_to],
        "sender" => "account@eversole.network", // must be a verified sender
        "subject" => $subject,
        "text_body" => strip_tags($body),
        "html_body" => $body,
    ];

    $ch = curl_init("https://api.smtp2go.com/v3/email/send");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        error_log("SMTP2GO cURL error: " . curl_error($ch));
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    $resp = json_decode($response, true);
    if (!$resp || empty($resp['data']['succeeded']) || $resp['data']['succeeded'] == 0) {
        error_log("SMTP2GO API error: " . $response);
        return false;
    }

    return true;
}

function send_verification($email, $reset = false) {
    //ensure there is no valid email sent, to prevent spamming of the server
    $user_id = run_query("SELECT id FROM users WHERE email = :e;", [":e" => $email])[0]['id'] ?? null;
    $last_request = run_query("SELECT expires FROM email_verification WHERE user_id = :id AND type = 'verify_email';", [":id" => $user_id]);

    if ($last_request && new DateTime() < new DateTime($last_request[0]['expires'])) {
        return false;
    }

    require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/scripts/features/functions.php');
    include realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/maintenance.php');

    $user = run_query("SELECT password FROM users WHERE id = :id;", [":id" => $user_id]);
    if (empty($user)) {
        return false;
    }
    $user = $user[0];
    if ($user["password"]) {
        return false;
    }

    $display = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: $email;

    $website = "{INSERT WEB ADDRESS}";
    if ($xampp) {
        $website = "https://localhost";
    }

    $token = bin2hex(random_bytes(32));
    $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $subject = "NHS Account Verification";

    $body = '<p>Hello ' . htmlspecialchars($display, ENT_QUOTES, 'UTF-8') . ',</p>' .
            '<p>Click the link below to finish setting up your account:</p>' .
            '<p><a href="' . $website . '?url=email&token=' . $token . '">Finish Setup</a></p>' .
            '<p>This link expires at: ' . $expires_at . '</p>';
    if ($reset) {
        $body = '<p>Hello ' . htmlspecialchars($display, ENT_QUOTES, 'UTF-8') . ',</p>' .
        '<p>Click the link below to reset your password:</p>' .
        '<p><a href="' . $website . '?url=email&token=' . $token . '">Reset Password</a></p>' .
        '<p>This link expires at: ' . $expires_at . '</p>';

        $subject = "NHS Password Reset";
    }

    if (send_email($subject, $body, $email)) {
        run_query("DELETE FROM email_verification WHERE user_id = :id AND type = 'verify_email';", [":id" => $user_id]);
        run_query("INSERT INTO email_verification (user_id, token, expires, type) VALUES (:u, :t, :e, 'verify_email');", [":u" => $user_id, ":t" => $token, ":e" => $expires_at]);
        return true;
    }

    return false;



}

function evaluate_token($token) {
    $token_query = run_query("SELECT * FROM email_verification WHERE token = :t;", [":t" => $token])[0];
    if (!$token_query) {
        return "<h3>Token Doesn't Exist</h3>";
    } else {
        if (new DateTime() > new DateTime($token_query['expires'])) {
            return "<h3>Token Expired</h3>";
        } else {
            if ($token_query['type'] === "verify_email") {
                #verify email and delete token
                return " <h3>Set password</h3>
                <form action='/handle_POST.php' method='post'>
                <input name='password' placeholder='Password' type='password'>
                <input name='confirm-password' placeholder='Confirm Password' type='password'>

                <input name='token' type='hidden' value='" . $token . "'>
                <input name='request' type='hidden' value='set_password'>
                <input name='redirect' type='hidden' value='login'>
                
                <button>Set Password</button>
                </form>

                ";
            } else {
                return "<h3>Set a new password</h3>
                <form action='/handle_POST.php' method='post'>
                    <input name='state' placeholder='New Password' type='password'>
                    <button>Change</button>

                    <input name='request' type='hidden' value='alter_user'>
                    <input name='redirect' type='hidden' value='login'>
                    <input name='token' type='hidden' value='" . $token . "'>
                </form>
                ";

            }
        }
    }
}
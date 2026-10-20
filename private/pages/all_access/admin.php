<?php

if (!isset($_SESSION["user_id"]) || $_SESSION["user_permissions"] !== "admin") {
    header("Location: ../../index.php");
    die();

} 

require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <?php display_form_errors(); ?>
    <div class="sections">
        <div class="section">
            <h3>Set Server Messages</h3>
            <form action="/handle_POST.php" method="post">
                <label for="alert">Alert Message (yellow banner on homepage):</label><br>
                <textarea name="alert" id="alert" cols="30" rows="2"><?php echo file_get_contents(realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/scripts/view/messages/alert.txt')); ?></textarea><br>
                <label for="motd">Message of the Day (displayed on homepage):</label><br>
                <textarea name="motd" id="motd" cols="30" rows="2"><?php echo file_get_contents(realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/scripts/view/messages/motd.txt')); ?></textarea><br>
                <input type="hidden" name="request" value="set_messages">
                <input type="hidden" name="redirect" value="admin">
                <button>Set Messages</button>
            </form>
        </div>
    </div> 
</body>
</html>
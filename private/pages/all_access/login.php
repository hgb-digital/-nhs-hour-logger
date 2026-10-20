<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/login/login_view.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENET: Login</title>
</head>
<body>
    <?php
    if (!isset($_SESSION["user_id"])) {
        include_once($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");
        
        ?>

        <h3>Login</h3>
        <form action="handle_POST.php" method="post">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pwd" placeholder="Password">
            <input type="hidden" name="request" value="login">
            <input type="hidden" name="redirect" value="login">
            <button>Login</button>
        </form>
        
        <a href="/?url=forgot">Forgot password?</a>

        <br>
        <p>New Member? <a href="/?url=signup">Get Started</a></p>
    <?php display_form_errors(); ?>
    <?php } else {
        header("Location: ../../index.php?");
        die();
    }
    ?>
    
</body>
</html>
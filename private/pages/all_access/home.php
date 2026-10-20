<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centennial NHS</title>
</head>
<style>
    #alert {
        background-color: yellow;
    }
    #committee {
        color: yellow;
    }
    #title {
        color: #ff8c00;
    }
</style>
<body>

    <h1>Centennial NHS</h1>
    <?php
        if (isset($_SESSION['user_id'])) {
            echo "<p>Welcome back, " . htmlspecialchars($_SESSION['user_first_name'] ?? $_SESSION['user_email'], ENT_QUOTES, 'UTF-8') . "!</p>";
            if ($_SESSION['user_committee'] == "officer") {
                echo "<p id='title'>" . strtoupper($_SESSION['user_title']) . "</p>";
            } else if (isset($_SESSION['user_committee'])) {
                echo "<p id='committee'> " . (strtoupper($_SESSION['user_committee'])) . (($_SESSION['user_permissions'] == "chair") ? " CHAIR" : "") . "</p>";
            }
            echo "<p> Class of " . $_SESSION['user_year'] . "</p>";
        } else {
            echo "<p>Welcome to the Centennial NHS website! Please <a href='/?url=login'>log in</a> or <a href='/?url=signup'>sign up</a> to get started.</p>";
        }
    ?>

    <br>
    <br>
    <p>Server Message: </p>
    <?php
        $motd = file_get_contents(realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/scripts/view/messages/motd.txt'));
        echo '<p>' . $motd . '</p>';
    ?>

</body>
</html>
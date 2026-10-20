<?php

include "../private/maintenance.php";

if (!$maintenance) {
    include "../private/dbh_manager.php";
    include "../private/scripts/features/config_session.php";
    include "../private/scripts/view/header.php";
    include_once "../private/scripts/features/functions.php";

    #Open Main Page
    $page = isset($_GET['url']) ? $_GET['url'] : 'home';

    $unrestricted_pages = ['home', 'login', 'signup', 'email', 'forgot'];
    if (!in_array($page, $unrestricted_pages) && !isset($_SESSION["user_id"])) {
        header("Location: /?url=home");
        die();
    }


    $folder = "../private/pages/all_access";

    $files = glob($folder . "/*.php");
    $file = $folder . "/" . $page . ".php";



    if (in_array($file, $files)) {
        include $file;
    } else {
        include $folder . "/../404.php";
    }

    include "../private/scripts/view/footer.php";
} else {
    echo "The server is undergoing maintenance";
}



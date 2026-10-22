<link rel="stylesheet" href="/serve_resources.php?type=css&file=table_style.css">
<link rel="stylesheet" href="/serve_resources.php?type=css&file=universal_styles.css">
<link rel="stylesheet" href="/serve_resources.php?type=css&file=section_styles.css">

<style>
    .navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #070b15;
        padding: 10px 20px;
        margin: 0px;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    .nav-links {
        list-style: none;
        display: flex;
        gap: 20px;
        padding-left: 5px;
    }
    .nav-links li a {
        color: white;
        text-decoration: none;
        font-size: 1em;
        transition: color 0.3s ease;
    }
    .nav-links li a:hover {
        color: yellow;
    }
    .acc-dropdown {
        position: relative;
        display: inline-block;
    }
    .acc-dropdown a {
        color: black;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }
    .acc-content {
        background-color: #070b15;
        display: none;
        position: absolute;
        z-index: 1;
    }           
    .acc-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        
    }
    .acc-dropdown:hover .acc-content {
        display: block;
    }

    #verify {
        background-color: yellow;
        padding: .25em;
        margin: 0em;
    }
    #alert {
        background-color: yellow;
        padding: .15em;
        margin: 0em;
        color: black;
    }

    #alert p {
        margin-left: 1.5em;
    }
</style>

<header>
<?php
    $msg = file_get_contents(realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/scripts/view/messages/alert.txt'));
    if ($msg) {
        echo "<div id='alert'><strong><p>ALERT: " . $msg . "</p></strong></div>";
    }

?>
<nav class="navigation">
    <ul class="nav-links">
            
            <li><a href="/">Home</a></li>
            <?php
            if (isset($_SESSION['user_id'])) {
                echo "<li><a href='/?url=log-hours'>Log Hours</a></li>";
                echo "<li><a href='/?url=group-service'>Group Service</a></li>";
                echo "<li><a href='/?url=chapter-stats'>Chapter Stats</a></li>";
                echo "<li><a href='/?url=members'>Members</a></li>";

                if ($_SESSION['user_permissions'] == "admin") {
                    echo "<li><a href='/?url=admin' style='color: red;'>Admin Panel</a></li>";
                }
                    
                } ?>
    </ul>
    <?php if (isset($_SESSION['user_id'])) { 
        $display = trim(($_SESSION['user_first_name'] ?? '') . ' ' . ($_SESSION['user_last_name'] ?? '')) ?: ($_SESSION['user_email'] ?? ($_SESSION['user_username'] ?? 'Account'));
    ?>
        <ul class="nav-links">
            <li class="acc-dropdown">
                <a href="/?url=members&member=<?php echo $_SESSION['user_id']; ?>" class="nav-account"><?php echo htmlspecialchars($display, ENT_QUOTES, 'UTF-8'); ?></a>
                <div class="acc-content">
                    <a href="/?url=logout">Logout</a>
                </div>
            </li>
            </ul>
    <?php } else {?>
            <ul class="nav-links">
            <li><a href="/?url=login">Login</a></li>
            </ul>
    <?php } ?>
            
</nav>
</header>

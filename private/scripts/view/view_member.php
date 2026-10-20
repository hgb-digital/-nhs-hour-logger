<?php

$member_info = run_query("SELECT first_name, last_name, email, committee, title, graduation_year, permissions FROM users WHERE id = :id;", [':id' => intval($_GET['member'])])[0];

$isp = run_query("SELECT * from hours WHERE user_id = :id AND type = 'isp';", [':id' => intval($_GET['member'])]);
$gsp = run_query("SELECT role_id, duration, timestamp, hours.id, service_roles.description as role_description, service_roles.sheet_id as sheet_id, service_sheet.title as sheet_title from hours JOIN service_roles ON hours.role_id = service_roles.id JOIN service_sheet ON service_roles.sheet_id = service_sheet.id WHERE user_id = :id AND type = 'gsp';", [':id' => intval($_GET['member'])]);

function hour_table($type, $table_data) {
    $permissions = $_SESSION['user_permissions'];
    $title = $_SESSION['user_title'];
    echo"<h2>" . strtoupper($type) . " Hours</h2>";
    if ($type == 'isp'){ 
        echo "<table>
        <tr>

            <th>Title</th>
            <th>Duration</th>
            <th>Description</th>";
        
        if($permissions == "officer" || $permissions == "admin") { 
            echo "<th> Supervisor Name </th> <th> Supervisor Contact </th> "; 
        }

        
        echo "<th>Date Logged</th>";
        if ($permissions == "admin" || $title == "parliamentarian") {
            echo "<th>Options</th>";
        }
        echo "</tr>";
        foreach ($table_data as $row) {
            echo "<tr>
            <td>" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['duration'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') . "</td>";
             if($permissions == "officer" || $permissions == "admin") { echo "<td>" . htmlspecialchars($row['supervisor_name'], ENT_QUOTES, 'UTF-8') . "</td> <td>" . htmlspecialchars($row['supervisor_contact'], ENT_QUOTES, 'UTF-8') . "</td>"; }
            echo "<td>" . htmlspecialchars($row['timestamp'], ENT_QUOTES, 'UTF-8') . "</td>";
            if ($permissions == "admin" || $title == "parliamentarian") {
                echo "<td><button onclick='removeHour(" . $row['id'] . ")'>Delete</button></td>";
            }
            echo "</tr>";
        }
        if (empty($table_data)) {
            echo "<tr><td colspan='5'>No ISP hours logged.</td></tr>";
        }

        echo "</table>";
    } elseif ($type == 'gsp') {
        echo " <table>
        <tr>
            <th>Title</th>
            <th>Duration</th>
            <th>Description</th>
            <th>Date Logged</th>";
        if ($permissions == "admin" || $title == "parliamentarian") {
                    echo "<th>Options</th>";
                }
                echo "</tr>";
        foreach ($table_data as $row) {
            echo "<tr>
            <td><a href='/?url=group-service&service=" . htmlspecialchars($row['sheet_id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['sheet_title'], ENT_QUOTES, 'UTF-8') . "</a></td>
            <td>" . htmlspecialchars($row['duration'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['role_description'], ENT_QUOTES, 'UTF-8') . "</td>
            <td>" . htmlspecialchars($row['timestamp'], ENT_QUOTES, 'UTF-8') . "</td>";
            if ($permissions == "admin" || $title == "parliamentarian") {
                echo "<td><button onclick='removeHour(" . $row['id'] . ")'>Delete</button></td>";
            }
            echo "</tr>";
        }
        if (empty($table_data)) {
            echo "<tr><td colspan='4'>No GSP hours logged.</td></tr>";
        }
        echo "</table>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $member_info['first_name'] . ' ' . $member_info['last_name']; ?></title>
</head>
<body>
    <style>
        .info {
            text-align: center;
        }
        .officer {
            color: #ff8c00;
        }

    </style>
    <?php if($_SESSION['user_permissions'] == 'admin' || $_SESSION['user_title'] == "parliamentarian") { ?>
    <script>
        function removeHour(id) {
            if (confirm("Are you sure you want to delete this hour entry? This action cannot be undone.")) {
                fetch("/handle_POST.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        request: "edit_hour",
                        data: {
                            hour_id: id,
                            edit: "delete"
                        }
                    })
                })
                .then(response => response.json())
                .then(data => {
                    location.reload();
                })
                .catch(error => {
                    alert("Network error: " + error);
                });
            }
        }
    </script>
    <?php } ?>
    <h1><?php echo $member_info['first_name'] . ' ' . $member_info['last_name']; ?></h1>
    <h3 class="info officer">
    <?php 
    echo strtoupper(
        ($member_info['committee'] === 'officer')
            ? $member_info['title']
            : (
                ($member_info['permissions'] === 'chair')
                    ? $member_info['committee'] . " CHAIR"
                    : $member_info['committee']
            )
    );
    ?> </h3>
    <p class="info" style="font-style: italic;">Class of <?php echo $member_info['graduation_year']; ?></p>
    <div class="sections">
        <div class="section">
            <?php hour_table('isp', $isp); ?>
        </div>
        <div class="section">
            <?php hour_table('gsp', $gsp); ?>
        </div>
    </div>
</body>
</html>


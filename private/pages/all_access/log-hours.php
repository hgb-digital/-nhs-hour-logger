<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: /?url=home");
    exit();
}

require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");

$logged_isp = run_query("SELECT id, title, description, duration, supervisor_name, supervisor_contact, timestamp ,SUM(duration) as total_hours FROM hours WHERE user_id = :id AND type = 'isp' GROUP BY title, description, duration, supervisor_name, supervisor_contact, timestamp;", [":id" => $_SESSION['user_id']]);
$logged_gsp = run_query("SELECT id, duration, timestamp, role_id, SUM(duration) as total_hours FROM hours WHERE user_id = :id AND type = 'gsp' GROUP BY duration, timestamp, role_id;", [":id" => $_SESSION['user_id']]);

$participated = run_query("SELECT
    ss.id AS sheet_id,
    ss.title,
    ss.event_date,
    sr.id AS role_id,
    sr.description as role_description
FROM signups s
JOIN service_roles sr
    ON s.role_id = sr.id
JOIN service_sheet ss
    ON sr.sheet_id = ss.id
WHERE s.user_id = :id
  AND ss.event_date < NOW()
  AND NOT EXISTS (
      SELECT 1
      FROM hours h
      WHERE h.role_id = sr.id
        AND h.type = 'gsp'
        AND h.user_id = s.user_id
  );", [":id" => $_SESSION['user_id']]);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Hours</title>
    <link rel="stylesheet" href="/serve_resources.php?type=css&file=section_styles.css">
</head>
<body>
    <style>
        .hours {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <script>
        function toggleForm(type) {
            const descriptionField = document.querySelector('input[name="description"]');
            const supervisorNameField = document.querySelector('input[name="supervisor_name"]');
            const supervisorContactField = document.querySelector('input[name="supervisor_contact"]');
            const titleField = document.querySelector('input[name="title"]');
            const ispButton = document.getElementById('isp-button');
            const gspButton = document.getElementById('gsp-button');

            const submitButton = document.getElementById('submit');
            const hoursField = document.querySelector('input[name="hours"]');
            const gspSelector = document.getElementById('gsp-selector');

            const selectionField = document.getElementById('gspField');


            if (type === 'isp') {
                submitButton.disabled = false;
                submitButton.style.display = 'inline-block';
                hoursField.style.display = 'inline-block';
                gspSelector.style.display = 'none';

                descriptionField.style.display = 'inline-block';
                supervisorNameField.style.display = 'inline-block';
                supervisorContactField.style.display = 'inline-block';
                titleField.style.display = 'inline-block';
                ispButton.style.backgroundColor = 'yellow';
                gspButton.style.backgroundColor = '#f0f0f0';

                if (selectionField) {
                    selectionField.value = "";
                }
            } else {
                descriptionField.style.display = 'none';
                supervisorNameField.style.display = 'none';
                supervisorContactField.style.display = 'none';
                titleField.style.display = 'none';
                gspButton.style.backgroundColor = 'yellow';
                ispButton.style.backgroundColor = '#f0f0f0';
                gspSelector.style.display = 'inline-block';
                submitButton.disabled = false;
                submitButton.style.display = 'inline-block';
                hoursField.style.display = 'inline-block';

                if (<?php echo !empty($participated) ? 'true' : 'false'; ?> === false) {
                    submitButton.disabled = true;
                    submitButton.style.display = 'none';
                    hoursField.style.display = 'none';
                }
            }
        }

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

        document.addEventListener('DOMContentLoaded', function() {
            toggleForm('isp');
        });
    </script>
    <br>
    <div class="sections">
        <div class="section full-section hours">
            <h3>ISP: <?php echo number_format($logged_isp[0]['total_hours'] ?? 0, 2); ?> hours</h3>
            <h3>GSP: <?php echo number_format($logged_gsp[0]['total_hours'] ?? 0, 2); ?> hours</h3>
        </div>
        <div class="section full-section">

            <h1>Log Hours</h1>
            <button onclick="toggleForm('isp')" id="isp-button" style="background-color: #4CAF50;">Individual</button>
            <button onclick="toggleForm('gsp')" id="gsp-button" style="background-color: #f0f0f0;">Group</button>
            <form action="handle_POST.php" method="post">
                
                <!-- Changes based on ISP or GSP -->
                <input type="text" name="title" placeholder="Title">
                <input type="text" name="description" placeholder="Description">
                <input type="text" name="supervisor_name" placeholder="Supervisor Name">
                <input type="text" name="supervisor_contact" placeholder="Supervisor Contact">

                <div style="display: inline-block;" id="gsp-selector">
                    <?php if (!empty($participated)) { ?>
                    <select name="gsp" id="gspField">
                        <?php
                        echo "<option value='' disabled selected>Select a GSP role</option>";
                        foreach ($participated as $entry) {
                            echo "<option value='" . htmlspecialchars($entry['role_id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($entry['title'], ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($entry['role_description'], ENT_QUOTES, 'UTF-8') . "</option>";
                        }
                        ?>
                    </select>
                    <?php } else {
                        echo "<p>You haven't signed up for any GSPs or have already logged them</p>";
                    } ?>
                </div>

                <input type="number" name="hours" placeholder="Hours" step="0.25" min=".25">
                <input type="hidden" name="request" value="log_hours">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <input type="hidden" name="redirect" value="log-hours">

                <button id="submit">Submit</button>
            </form>
            <?php display_form_errors("Hours Logged"); ?>
        </div>
        <div class="section">
            <h2>ISP</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Hours</th>
                    <th>Supervisor Name</th>
                    <th>Supervisor Contact</th>
                    <th>Date Logged</th>
                    <th>Options</th>
                </tr>
                <?php
                foreach ($logged_isp as $entry) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($entry['title'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($entry['description'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($entry['duration'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($entry['supervisor_name'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($entry['supervisor_contact'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($entry['timestamp'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td><button onclick='removeHour(" . $entry['id'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
                if (count($logged_isp) == 0) {
                    echo "<tr><td colspan='7'>No ISP hours logged yet.</td></tr>";
                }
                ?>
            </table>
        </div>
        <div class="section">
            <h2>GSP</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Hours</th>
                    <th>Date Logged</th>
                    <th>Options</th>
                </tr>
                <?php
                foreach ($logged_gsp as $entry) {
                    $role = run_query(
                        "SELECT sr.description, ss.title
                        FROM service_roles sr
                        JOIN service_sheet ss ON sr.sheet_id = ss.id
                        WHERE sr.id = :id;",
                        [":id" => $entry['role_id']]
                    );
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($role[0]['title'], ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars($role[0]['description'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($entry['duration'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($entry['timestamp'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td><button onclick='removeHour(" . $entry['id'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
                if (count($logged_gsp) == 0) {
                    echo "<tr><td colspan='7'>No GSP hours logged yet.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
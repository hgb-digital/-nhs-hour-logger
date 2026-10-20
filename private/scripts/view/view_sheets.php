<?php

$sheets_past = run_query("

SELECT ss.*, latest.start_time, latest.end_time
FROM service_sheet ss
JOIN (
    SELECT sheet_id, MAX(time) AS end_time, MIN(time) AS start_time
    FROM service_roles
    GROUP BY sheet_id
) latest ON ss.id = latest.sheet_id
WHERE latest.end_time <= NOW();

");

$sheets_upcoming = run_query("

SELECT ss.*, latest.start_time, latest.end_time
FROM service_sheet ss
JOIN (
    SELECT sheet_id, MAX(time) AS end_time, MIN(time) AS start_time
    FROM service_roles
    GROUP BY sheet_id
) latest ON ss.id = latest.sheet_id
WHERE latest.end_time > NOW();

");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Service</title>
    <link rel="stylesheet" href="/serve_resources.php?type=css&file=section_styles.css">
</head>

<body>

<h1>Group Service Opportunities</h1>

<?php if (isset($_SESSION['user_id']) && in_array($_SESSION['user_permissions'], ["admin", "officer", "chair"])): ?>
    <a href="/?url=create-service"><button>Create New Sheet</button></a>
<?php endif; ?>

<h2>Upcoming</h2>
<div class="sections">

<?php foreach ($sheets_upcoming as $sheet): ?>

    <?php
        $start = strtotime($sheet['start_time']);
        $end = strtotime($sheet['end_time']);

        if ($start == $end) {
            $display = date("l, F j, Y, g:i A", $start);
        } else {
            $display =
                "(" . date("l, F j, Y, g:i A", $start) . ") TO (" .
                date("l, F j, Y, g:i A", $end) . ")";
        }
    ?>

    <div class="section">
        <h3>
            <a href="/?url=group-service&service=<?php echo $sheet['id']; ?>">
                <?php echo $sheet['title']; ?>
            </a>
        </h3>

        <strong><p><?php echo $display; ?></p></strong>

        <p><?php echo $sheet['description']; ?></p>
    </div>

<?php endforeach; ?>

</div>

<h2>Past</h2>
<div class="sections">

<?php foreach ($sheets_past as $sheet): ?>

    <?php
        $start = strtotime($sheet['start_time']);
        $end = strtotime($sheet['end_time']);

        if ($start == $end) {
            $display = date("l, F j, Y, g:i A", $start);
        } else {
            $display =
                "(" . date("l, F j, Y, g:i A", $start) . ") TO (" .
                date("l, F j, Y, g:i A", $end) . ")";
        }
    ?>

    <div class="section">
        <h3>
            <a href="/?url=group-service&service=<?php echo $sheet['id']; ?>">
                <?php echo $sheet['title']; ?>
            </a>
        </h3>

        <strong><p><?php echo $display; ?></p></strong>

        <p><?php echo $sheet['description']; ?></p>
    </div>

<?php endforeach; ?>

</div>

</body>
</html>
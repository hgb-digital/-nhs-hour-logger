<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");

$service_id = $_GET['service'];

$sheet = run_query("
SELECT title, description 
FROM service_sheet 
WHERE id = :id
", [':id' => $service_id])[0];

$role_times = run_query("
SELECT 
    MIN(time) AS start_time,
    MAX(time) AS end_time
FROM service_roles
WHERE sheet_id = :id
GROUP BY sheet_id
", [':id' => $service_id])[0];

$roles = run_query("
SELECT id, description, slots, time, location, attire
FROM service_roles
WHERE sheet_id = :id
ORDER BY time ASC
", [':id' => $service_id]);

$signups = [];
$user_signed_up = [];

foreach ($roles as $role) {

    $role_id = $role['id'];

    $temp = run_query("
        SELECT 1 
        FROM signups 
        WHERE role_id = :id AND user_id = :user_id
    ", [
        ':id' => $role_id,
        ':user_id' => $_SESSION['user_id']
    ]);

    $user_signed_up[$role_id] = isset($temp[0]);

    $signups[$role_id] = run_query("
        SELECT u.first_name, u.last_name
        FROM signups s
        JOIN users u ON s.user_id = u.id
        WHERE s.role_id = :id
    ", [':id' => $role_id]);
}

$start_time = $role_times['start_time'];
$end_time = $role_times['end_time'];

if ($start_time == $end_time) {
    $sheet_time = date("l, F j, Y, g:i A", strtotime($start_time));
} else {
    $sheet_time =
        "(" . date("l, F j, Y, g:i A", strtotime($start_time)) . ") TO (" .
        date("l, F j, Y, g:i A", strtotime($end_time)) . ")";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $sheet['title']; ?></title>
<link rel="stylesheet" href="/serve_resources.php?type=css&file=section_styles.css">

<style>
.title-card, .role-card {
    text-align: center;
}

.role-table {
    margin: 0 auto;
}

.role-table table {
    margin: 0 auto;
}

.full { color: red; }
.available { color: green; }
</style>
</head>

<body>

<a href="/?url=group-service"><p>Return to list</p></a>

<p><?php display_form_errors(""); ?></p>

<div class="sections">

    <div class="section full-section title-card">
        <h1><?php echo $sheet['title']; ?></h1>
        <p><?php echo $sheet['description']; ?></p>
        <strong><?php echo $sheet_time; ?></strong>
    </div>

    <?php foreach ($roles as $role): ?>

        <?php
            $role_id = $role['id'];
            $role_time = strtotime($role['time']);
            $role_open = $role_time > time();

            $filled = count($signups[$role_id]);
            $remaining = intval($role['slots']) - $filled;

            $role_display_time = date("l, F j, Y, g:i A", $role_time);
        ?>

        <div class="section role-card">

            <h2><?php echo $role['description']; ?></h2>

            <p><strong><?php echo $role_display_time; ?></strong></p>

            <?php if (!empty($role['location'])): ?>
                <p>Location: <?php echo $role['location']; ?></p>
            <?php endif; ?>

            <?php if (!empty($role['attire'])): ?>
                <p>Attire: <?php echo $role['attire']; ?></p>
            <?php endif; ?>

            <div class="role-table">
                <table>
                    <tr>
                        <th>Volunteer Name</th>
                    </tr>

                    <?php if (count($signups[$role_id]) > 0): ?>
                        <?php foreach ($signups[$role_id] as $signup): ?>
                            <tr>
                                <td>
                                    <?php echo $signup['first_name'] . ' ' . $signup['last_name']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td><em>No volunteers yet</em></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <?php if ($role_open): ?>

                <?php if ($remaining > 0): ?>
                    <p class="available"><?php echo $remaining; ?> slots remaining</p>
                <?php else: ?>
                    <p class="full"><em>All slots full</em></p>
                <?php endif; ?>

                <?php if ($user_signed_up[$role_id]): ?>
                    <form action="handle_POST.php" method="post">
                        <input type="hidden" name="request" value="signup_service">
                        <input type="hidden" name="role_id" value="<?php echo $role_id; ?>">
                        <input type="hidden" name="type" value="remove">
                        <input type="hidden" name="redirect" value="group-service&service=<?php echo $service_id; ?>">
                        <button>Remove Signup</button>
                    </form>
                <?php elseif ($remaining > 0): ?>
                    <form action="handle_POST.php" method="post">
                        <input type="hidden" name="request" value="signup_service">
                        <input type="hidden" name="role_id" value="<?php echo $role_id; ?>">
                        <input type="hidden" name="type" value="add">
                        <input type="hidden" name="redirect" value="group-service&service=<?php echo $service_id; ?>">
                        <button>Sign Up</button>
                    </form>
                <?php endif; ?>

            <?php else: ?>
                <p class="full"><em>Signups closed for this role</em></p>
            <?php endif; ?>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>
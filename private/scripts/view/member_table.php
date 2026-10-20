<?php
function getMembers($title = null, $committee = null) {
    $sql = "
        SELECT 
            users.first_name,
            users.last_name,
            users.email,
            users.id,
            users.title,
            users.committee,
            COALESCE(SUM(CASE WHEN hours.type = 'isp' THEN hours.duration ELSE 0 END), 0) AS isp_hours,
            COALESCE(SUM(CASE WHEN hours.type = 'gsp' THEN hours.duration ELSE 0 END), 0) AS gsp_hours
        FROM users
        LEFT JOIN hours ON users.id = hours.user_id
        WHERE 1=1
    ";

    $params = [];

    if ($title !== null) {
        $sql .= " AND users.title = :title";
        $params[":title"] = $title;
    }

    if ($committee !== null) {
        $sql .= " AND users.committee = :committee";
        $params[":committee"] = $committee;
    }

    $sql .= " GROUP BY users.id";

    return run_query($sql, $params);
}

function formatTitle($title) {
    if (!$title) return "Member";

    if ($title === "oal") return "Officer At Large";

    if (str_starts_with($title, "sr_")) {
        return "Senior " . ucfirst(str_replace("sr_", "", $title));
    }

    if (str_starts_with($title, "jr_")) {
        return "Junior " . ucfirst(str_replace("jr_", "", $title));
    }

    return ucfirst(str_replace("_", " ", $title));
}

$officers = [
    "president" => "President",
    "vice_president" => "Vice President",
    "treasurer" => "Treasurer",
    "publicist" => "Publicist",
    "oal" => "Officer At Large"
];

$committees = [
    "polis" => "Polis",
    "fundraiser" => "Fundraiser",
    "elders" => "Elders",
    "assembly" => "Assembly"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Members</title>
</head>
<body>

<h1>Members</h1>

<div class="sections">

    <!-- ================= OFFICERS ================= -->
    <div class="section full-section">
        <h2>Officers</h2>

        <table
            <tr>
                <th>Title</th>
                <th>Name</th>
                <th>ISP Hours</th>
                <th>GSP Hours</th>
                <th>Email</th>
            </tr>

            <?php foreach ($officers as $key => $label): ?>
                <?php $user = getMembers($key)[0] ?? null; ?>

                <tr>
                    <td><?= $label ?></td>

                    <td>
                        <?php if ($user): ?>
                            <a href="?url=members&member=<?= $user['id'] ?>">
                                <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td><?= $user['isp_hours'] ?? 0 ?></td>
                    <td><?= $user['gsp_hours'] ?? 0 ?></td>

                    <td>
                        <?php if ($user): ?>
                            <a href="mailto:<?= htmlspecialchars($user['email']) ?>">
                                <?= htmlspecialchars($user['email']) ?>
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- ================= COMMITTEES ================= -->
    <?php foreach ($committees as $key => $label): ?>
        <?php $members = getMembers(null, $key); ?>

        <div class="section">
            <h2><?= $label ?></h2>

            <table>
                <tr>
                    <th>Title</th>
                    <th>Name</th>
                    <th>ISP Hours</th>
                    <th>GSP Hours</th>
                </tr>

                <?php foreach ($members as $m): ?>
                    <tr>
                        <td><?= formatTitle($m['title']) ?></td>

                        <td>
                            <a href="?url=members&member=<?= $m['id'] ?>">
                                <?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?>
                            </a>
                        </td>

                        <td><?= $m['isp_hours'] ?></td>
                        <td><?= $m['gsp_hours'] ?></td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    <?php endforeach; ?>

</div>

</body>
</html>
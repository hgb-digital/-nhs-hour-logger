<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: /?url=home");
    exit();
}

$temp = run_query("SELECT id FROM service_sheet");
$service_ids = [];
foreach ($temp as $row) {
    $service_ids[] = $row['id'];
}

if (in_array($_GET['service'] ?? '', $service_ids)) {
    require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/view/view_service.php");
} else {
    require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/view/view_sheets.php");
}
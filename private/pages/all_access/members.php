<?php


if (isset($_GET['member'])) {
    $member = run_query("SELECT id FROM users WHERE id = :id;", [':id' => intval($_GET['member'])])[0] ?? null;
    if ($member) {
        require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/view/view_member.php");
    } else {
        require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/view/member_table.php");
    }
} else {
    require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/view/member_table.php");
}
<?php

function set_announcement($data) {
    if (!isset($data['content']) || !isset($data['title'])) {
        return ['errors' => ['empty_input']];
    }

    $user = $_SESSION['user_id'];
    run_query("INSERT INTO announcements (title, html, user_id) VALUES (:t, :c, :u);", [':t' => $data['title'], ":c" => $data['content'], ":u" => $user]);
    return true;

}
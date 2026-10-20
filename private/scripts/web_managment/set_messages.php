<?php

function set_messages($data) {
    if (!isset($data['alert']) || !isset($data['motd'])) {
        return ['errors' => ["empty_input"]];
    }
    file_put_contents(realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/scripts/view/messages/alert.txt'), $data['alert']);
    file_put_contents(realpath($_SERVER['DOCUMENT_ROOT'] . '/../private/scripts/view/messages/motd.txt'), $data['motd']);
    return true;
}
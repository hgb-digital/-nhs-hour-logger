<?php

// ensure only admins on this page
if (!isset($_SESSION['user_id']) || (!in_array($_SESSION['user_permissions'], ["admin", "officer", "chair"]))) {
    header("Location: /?url=home");
    exit();
}

require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Service</title>
</head>
<script>
    let roleCount = 0;

    function addRole() {
        roleCount++;
        const container = document.getElementById('roles_container');
        const roleDiv = document.createElement('div');
        roleDiv.classList.add('role_entry');
        roleDiv.id = `e_${roleCount}`;

        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        const formatted = now.toISOString().slice(0,16);

        roleDiv.innerHTML = `
            <p>Role ${roleCount}:</p>
            <input type="text" name="role_${roleCount}_title" placeholder="Role Name">
            <input type="datetime-local" name="role_${roleCount}_time" placeholder="Role Time" min="${formatted}">
            <input type="text" name="role_${roleCount}_loc" placeholder="Role Location">
            <input type="text" name="role_${roleCount}_desc" placeholder="Role Description">
            <button type="button" onclick="addAttr('attire', ${roleCount})" id="a_${roleCount}">Add Attire</button>
            <input type="number" name="role_${roleCount}_slots" placeholder="Slots Available" min="1">
        `;
        container.appendChild(roleDiv);
        document.getElementById('role_count').value = roleCount;
    }
    function addAttr(attr, id) {
        const div = document.getElementById(`e_${id}`);
        if (!div) {
            return false;
        }
        
        if (!(['attire'].includes(attr))) {
            return false;
        }

        if (attr == "attire") {
            const new_input = document.createElement('input');
            new_input.type = "text"
            new_input.name = `role_${id}_attire`
            new_input.placeholder = "Event Attire"
            document.getElementById(`a_${id}`).replaceWith(new_input);
            return;
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
            addRole();
    });
</script>
<body>
    <h1>Create Group Service</h1>
    <form action="handle_POST.php" method="post">
        <h3>Info</h3>
        <input type="text" name="title" placeholder="Title">
        <input type="text" name="description" placeholder="Description">

        <input type="hidden" name="request" value="create_service">
        <input type="hidden" name="redirect" value="create-service">
        <input type="hidden" name="role_count" id="role_count" value="1">

        <h3>Roles</h3>
        <div id="roles_container">
        </div>
        <br>
        <button type="button" onclick="addRole()">Add Role</button>
        <p>--</p>

        <button>Create</button>
        <?php display_form_errors("Successfully Created!"); ?>
    </form>
</body>
</html>
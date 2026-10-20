<?php

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_permissions'], ['admin', 'officer'])) {
    header("Location: /?url=home");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Announcement</title>

    <!-- Quill CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
</head>
<body>

<h1>Set Announcement</h1>

<form method="POST" action="/handle_POST.php">
    <input type="text" name="title" placeholder="Title"><br><br>

    <!-- Toolbar -->
    <div id="toolbar">
        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-underline"></button>

        <button class="ql-list" value="ordered"></button>
        <button class="ql-list" value="bullet"></button>

        <button class="ql-link"></button>
    </div>

    <!-- Editor -->
    <div id="editor" style="height: 250px;"></div>

    <!-- Hidden input to send HTML -->
    <input type="hidden" name="content" id="content">
    <input type="hidden" name="request" id="set_announcement">
    <input type="hidden" name="redirect" id="set-announcement">
    

    <br>
    <button type="submit">Post Announcement</button>
</form>

<p><?php display_form_errors("Post Success"); ?></p>

<!-- Quill JS -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: '#toolbar'
        }
    });

    // On submit, copy HTML into hidden input
    document.querySelector("form").onsubmit = function() {
        document.querySelector("#content").value = quill.root.innerHTML;
    };
</script>

<style>
    /* Make the editor container white */
#editor {
  background-color: white;
  font-size: 16px; /* increase base font size */
}

/* Toolbar styling (optional but cleaner) */
#toolbar {
 background-color: white;
  border: 1px solid #ccc;
  border-bottom: none;
}

/* Editor box styling */
.ql-container {
  font-size: 16px; /* slightly bigger text */
  border: 1px solid #ccc;
  border-top: none;
}

/* Actual text area inside Quill */
.ql-editor {
 background-color: black;
  min-height: 250px;
  font-size: 16px;
  line-height: 1.6;
  border: 1px solid #ccc;
}

/* Placeholder text */
.ql-editor.ql-blank::before {
  font-size: 16px;
  color: #999;
}
</style>

</body>
</html>
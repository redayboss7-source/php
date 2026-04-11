<?php
$folder = "img/"; // uploads folder

if (isset($_POST['submitbtn'])) {
    $file = $_FILES['f']['tmp_name'];
    $name = $_FILES['f']['name'];
    move_uploaded_file($file, $folder . $name);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Simple Gallery</title>
</head>

<body>

    <h2>Upload Image</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="f" required>
        <input type="submit" name="submitbtn" value="Upload">
    </form>

    <h2>Gallery</h2>
    <?php
    $files = scandir($folder);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<img src='" . $folder . $file . "' width='150' style='margin:5px'>";
        }
    }
    ?>




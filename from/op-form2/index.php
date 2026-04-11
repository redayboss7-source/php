<?php
require_once('student.php');


if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $batch = $_POST['batch'];

    if ($id != "" && $name != "" && $batch != "") {

        $student = new Student($id, $name, $batch);
        $student->dstore();

        echo "<h3 style='color:green;'>Student saved successfully!</h3>";

    } else {
        echo "<h3 style='color:red;'>All fields are required!</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Form</title>
    <style>
        div {
            width: 300px;
            margin: 40px auto;
            border: 2px solid black;
            padding: 15px;
            border-radius: 5px;
            table {
    margin-top: 20px;
    font-family: Arial;
}

th {
    background: #007bff;
    color: white;
}

tr:nth-child(even) {
    background: #f2f2f2;
}

tr:hover {
    background: #ddd;
}
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Student Form</h2>

<div>
<form method="post">
    Student ID:<br>
    <input type="text" name="id"><br><br>

    Student Name:<br>
    <input type="text" name="name"><br><br>

    Student Batch:<br>
    <input type="text" name="batch"><br><br>

    <input type="submit" name="submit" value="Submit">
</form>
</div>

<div style="width:300px; margin:auto;">
<?php

Student::result();
?>
</div>

</body>
</html>
<?php
require_once('student.php');

if (isset($_POST['save'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $batch = $_POST['batch'];

    $student = new Student($id, $name, $batch);
    $student->save();

    echo "Saved successfully!";
}

if (isset($_POST['search'])) {

    $search_id = $_POST['search_id'];

    $student = new Student(); 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student System</title>
</head>
<body>

<h2>Add Student</h2>

<form method="post">
    ID: <input type="text" name="id"><br><br>
    Name: <input type="text" name="name"><br><br>
    Batch: <input type="text" name="batch"><br><br>

    <input type="submit" name="save" value="Save">
</form>

<hr>

<h2>Search Student</h2>

<form method="post">
    Search ID: <input type="text" name="search_id"><br><br>

    <input type="submit" name="search" value="Search">
</form>

<?php
if (isset($_POST['search'])) {
    $student->result($_POST['search_id']);
}
?>

</body>
</html>
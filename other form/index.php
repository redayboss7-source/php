<?php
include "classes.php";

// আগে object create (important)
$s = new Student("", "", "");

// SAVE
if (isset($_POST["submit"])) {

    $name = htmlspecialchars($_POST["name"]);
    $id = htmlspecialchars($_POST["id"]);
    $address = htmlspecialchars($_POST["address"]);

    $s = new Student($name, $id, $address);
    $s->format();

    // Redirect (duplicate submit বন্ধ)
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple System</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            text-align: center;
        }

        form {
            background: white;
            padding: 20px;
            margin: 20px auto;
            width: 300px;
            border-radius: 10px;
        }

        input, button {
            width: 90%;
            padding: 8px;
            margin: 5px;
        }

        button {
            background: green;
            color: white;
            border: none;
        }

        table {
            margin: auto;
            background: white;
            border-collapse: collapse;
            width: 70%;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h2>Student Form</h2>

<form method="post">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="id" placeholder="ID" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <button name="submit">Save</button>
</form>

<br>

<table>
<tr>
    <th>Name</th>
    <th>ID</th>
    <th>Address</th>
</tr>

<?php 
$s->display();
?>

</table>

</body>
</html>
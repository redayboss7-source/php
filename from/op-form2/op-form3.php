<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>OOP Form</title>
</head>
<body>

<h2>User Information Form</h2>

<form method="POST">
    ID: <input type="text" name="id" required><br><br>
    Name: <input type="text" name="name" required><br><br>
    Address: <input type="text" name="address"><br><br>
    Contact: <input type="text" name="contact"><br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<?php

class User {
    public $name;
    public $id;
    public $address;
    public $contact;

    public function __construct($name, $id, $address, $contact) {
        $this->name = $name;
        $this->id = $id;
        $this->address = $address;
        $this->contact = $contact;
    }

    public function display() {
        echo "<h3>Submitted Data:</h3>";
        echo "ID: " . $this->id . "<br>";
        echo "Name: " . $this->name . "<br>";
        echo "Address: " . $this->address . "<br>";
        echo "Contact: " . $this->contact . "<br>";
    }

    public function saveToFile() {
        $data = "Name: $this->name\nID: $this->id\nAddress: $this->address\nContact: $this->contact\n-----------------\n";
        file_put_contents("users.txt", $data, FILE_APPEND);
    }
}

if (isset($_POST['submit'])) {
    $user = new User(
        $_POST['name'],
        $_POST['id'],
        $_POST['address'],
        $_POST['contact']
    );

    $user->saveToFile();
    $user->display();
}

?>

</body>
</html>
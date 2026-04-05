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
    Address: <input type="text" name="address" required><br><br>
    Contact: <input type="text" name="contact" required><br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<?php

class User {
    public $name;
    public $id;
    public $address;
    public $contact;

    public function __construct($name, $id, $address, $contact) {
        $this->id = $id;
        $this->name = $name;
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
        $data = "Name: " . $this->name . "\n" .
                "ID: " . $this->id . "\n" .
                "Address: " . $this->address . "\n" .
                "Contact: " . $this->contact . "\n";
        $data .= "--------------------------\n";

        file_put_contents("users.txt", $data, FILE_APPEND);
    }
}

if (isset($_POST['submit'])) {


    $name = htmlspecialchars($_POST['name']);
    $id = htmlspecialchars($_POST['id']);
    $address = htmlspecialchars($_POST['address']);
    $contact = htmlspecialchars($_POST['contact']);


    $user = new User($name, $id, $address, $contact);


    $user->saveToFile();


    $user->display();
}

?>

</body>
</html>
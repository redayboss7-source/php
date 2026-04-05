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
    Address: <input type="text" name="address" required><br><br>
    Contact: <input type="text" name="contact" required><br><br>

    <input type="submit" name="submit" value="Submit">
</form>

<?php

class User {
    private $name;
    private $id;
    private $address;
    private $contact;

    public function __construct($name, $id, $address, $contact) {
        $this->setName($name);
        $this->setId($id);
        $this->setAddress($address);
        $this->setContact($contact);
    }

    public function setName($name) {
        $this->name = trim($name);
    }

    public function setId($id) {
        $this->id = trim($id);
    }

    public function setAddress($address) {
        $this->address = trim($address);
    }

    public function setContact($contact) {
        $this->contact = trim($contact);
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getContact() {
        return $this->contact;
    }

    public function display() {
        echo "<h3>Submitted Data:</h3>";
        echo "ID: " . $this->getId() . "<br>";
        echo "Name: " . $this->getName() . "<br>";
        echo "Address: " . $this->getAddress() . "<br>";
        echo "Contact: " . $this->getContact() . "<br>";
    }

    public function saveToFile() {
        $data = "Name: " . $this->getName() . "\n" .
                "ID: " . $this->getId() . "\n" .
                "Address: " . $this->getAddress() . "\n" .
                "Contact: " . $this->getContact() . "\n";
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
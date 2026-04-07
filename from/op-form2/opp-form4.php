<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Advanced OOP Form Fixed</title>
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

<hr>

<?php

class Person {
    protected $id, $name, $address, $contact;

    public function __construct($id, $name, $address, $contact) {
        $this->id = trim($id);
        $this->name = trim($name);
        $this->address = trim($address);
        $this->contact = trim($contact);
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getAddress() { return $this->address; }
    public function getContact() { return $this->contact; }
}

class User extends Person {}

class FileManager {
    private $file = "users.txt";

    public function save(User $user) {
        $data  = "ID: {$user->getId()}\n";
        $data .= "Name: {$user->getName()}\n";
        $data .= "Address: {$user->getAddress()}\n";
        $data .= "Contact: {$user->getContact()}\n";
        $data .= "----------------------\n";

        file_put_contents($this->file, $data, FILE_APPEND);
    }

    public function read() {
        if (file_exists($this->file)) {
            return nl2br(file_get_contents($this->file));
        }
        return "No data found!";
    }

    public function countUsers() {
        if (file_exists($this->file)) {
            $content = file_get_contents($this->file);
            return substr_count($content, "ID:");
        }
        return 0;
    }
}

class DisplayManager {
    public function show(User $user) {
        echo "<h3>Submitted Data:</h3>";
        echo "ID: {$user->getId()}<br>";
        echo "Name: {$user->getName()}<br>";
        echo "Address: {$user->getAddress()}<br>";
        echo "Contact: {$user->getContact()}<br>";
    }
}

$file = new FileManager();

if (isset($_POST['submit'])) {

    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $contact = htmlspecialchars($_POST['contact']);

    if (empty($id) || empty($name) || empty($address) || empty($contact)) {
        echo "<b style='color:red;'>All fields are required!</b>";
    } else {

        $user = new User($id, $name, $address, $contact);

        $file->save($user);

        $_SESSION['success'] = "Data saved successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_SESSION['success'])) {
    echo "<b style='color:green;'>" . $_SESSION['success'] . "</b><br>";
    unset($_SESSION['success']);
}

echo "<br><b>Total Users: " . $file->countUsers() . "</b>";

echo "<hr>";
echo "<h3>All Saved Users:</h3>";
echo $file->read();

?>

</body>
</html>
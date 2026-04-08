<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?> 

<!DOCTYPE html>
<html>
<head>
    <title>Advanced OOP Form with Inheritance</title>
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
    protected $id;
    protected $name;
    protected $address;
    protected $contact;

    public function __construct($id, $name, $address, $contact) {
        $this->setId($id);
        $this->setName($name);
        $this->setAddress($address);
        $this->setContact($contact);
    }

    protected function setId($id) {
        $this->id = trim($id);
    }

    protected function setName($name) {
        $this->name = trim($name);
    }

    protected function setAddress($address) {
        $this->address = trim($address);
    }

    protected function setContact($contact) {
        $this->contact = trim($contact);
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getAddress() { return $this->address; }
    public function getContact() { return $this->contact; }
}


class User extends Person {
    private $role = "User";

    public function getRole() {
        return $this->role;
    }
}


class FileManager {
    public function save(User $user) {

        $data  = "ID: " . $user->getId() . "\n";
        $data .= "Name: " . $user->getName() . "\n";
        $data .= "Address: " . $user->getAddress() . "\n";
        $data .= "Contact: " . $user->getContact() . "\n";
        $data .= "Role: " . $user->getRole() . "\n";
        $data .= "----------------------\n";

        file_put_contents("users.txt", $data, FILE_APPEND);
    }

   
    public function read() {
        if (file_exists("users.txt")) {
            return nl2br(file_get_contents("users.txt"));
        } else {
            return "No data found!";
        }
    }
}


class DisplayManager {
    public function show(User $user) {
        echo "<h3>Submitted Data:</h3>";
        echo "ID: " . $user->getId() . "<br>";
        echo "Name: " . $user->getName() . "<br>";
        echo "Address: " . $user->getAddress() . "<br>";
        echo "Contact: " . $user->getContact() . "<br>";
        echo "Role: " . $user->getRole() . "<br>";
    }
}


class UserCounter {
    private static $count = 0;

    public static function increase() {
        self::$count++;
    }

    public static function getCount() {
        return self::$count;
    }
}


$file = new FileManager();

if (isset($_POST['submit'])) {

    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $contact = htmlspecialchars($_POST['contact']);

    $user = new User($id, $name, $address, $contact);

    UserCounter::increase();

    $file->save($user);

    $display = new DisplayManager();
    $display->show($user);

    echo "<br><b>Total Users: " . UserCounter::getCount() . "</b>";
}

echo "<hr>";
echo "<h3>All Saved Users (From TXT File):</h3>";
echo $file->read();

?>

</body>
</html>
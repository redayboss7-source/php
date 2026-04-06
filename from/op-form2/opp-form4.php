<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Advanced OOP Form</title>
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

// 🔹 Class 1: User
class User {
    private $id;
    private $name;
    private $address;
    private $contact;

    public function __construct($id, $name, $address, $contact) {
        $this->setId($id);
        $this->setName($name);
        $this->setAddress($address);
        $this->setContact($contact);
    }

    // 🔸 Setters
    public function setId($id) {
        $this->id = trim($id);
    }

    public function setName($name) {
        $this->name = trim($name);
    }

    public function setAddress($address) {
        $this->address = trim($address);
    }

    public function setContact($contact) {
        $this->contact = trim($contact);
    }

    // 🔸 Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getContact() {
        return $this->contact;
    }
}

// 🔹 Class 2: FileManager
class FileManager {

    public function save(User $user) {
        $data  = "ID: " . $user->getId() . "\n";
        $data .= "Name: " . $user->getName() . "\n";
        $data .= "Address: " . $user->getAddress() . "\n";
        $data .= "Contact: " . $user->getContact() . "\n";
        $data .= "----------------------\n";

        file_put_contents("users.txt", $data, FILE_APPEND);
    }
}

// 🔹 Class 3: DisplayManager
class DisplayManager {

    public function show(User $user) {
        echo "<h3>Submitted Data:</h3>";
        echo "ID: " . $user->getId() . "<br>";
        echo "Name: " . $user->getName() . "<br>";
        echo "Address: " . $user->getAddress() . "<br>";
        echo "Contact: " . $user->getContact() . "<br>";
    }
}

// 🔹 Class 4: UserCounter (Static Example)
class UserCounter {
    private static $count = 0;

    public static function increase() {
        self::$count++;
    }

    public static function getCount() {
        return self::$count;
    }
}


// 🔥 Main Logic
if (isset($_POST['submit'])) {

    $id = htmlspecialchars($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $contact = htmlspecialchars($_POST['contact']);

    // Create object
    $user = new User($id, $name, $address, $contact);

    // Increase count
    UserCounter::increase();

    // Save to file
    $file = new FileManager();
    $file->save($user);

    // Display data
    $display = new DisplayManager();
    $display->show($user);

    echo "<br><b>Total Users: " . UserCounter::getCount() . "</b>";
}

?>

</body>
</html>
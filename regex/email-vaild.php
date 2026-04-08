<?php
// $emails = [
//     "user@example.com",
//     "invalid.email",
//     "another.user@domain.org"
// ];
echo '<form method="post">Email: <input type="text" name="email"><input type="submit"></form>';
$email = $_POST['email'] ?? '';
$emails = [$email];

$pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

foreach ($emails as $email) {
    echo $email . " → " . (preg_match_all($pattern, $email) ? "Valid ✅" : "Invalid ❌") . "\n";
}
?>
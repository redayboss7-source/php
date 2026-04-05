<!DOCTYPE html>
<html>
<head>
    <title>Prime Number Checker</title>
</head>
<body>

<h2>Prime Number Check</h2>

<form method="post">
    Enter a number: 
    <input type="number" name="number" required>
    <input type="submit" name="check" value="Check">
</form>

<?php
function isPrime($num) {
    if ($num <= 1) {
        return false;
    }

    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

if (isset($_POST['check'])) {
    $number = $_POST['number'];

    if (isPrime($number)) {
        echo "<h3>$number is a Prime Number</h3>";
    } else {
        echo "<h3>$number is Not a Prime Number</h3>";
    }
}
?>

</body>
</html>
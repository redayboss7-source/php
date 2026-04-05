<!DOCTYPE html>
<html>
<head>
    <title>Fibonacci Generator</title>
</head>
<body>

<h2>Fibonacci Sequence Generator</h2>

<form method="post">
    Enter how many numbers: 
    <input type="number" name="num" required>
    <input type="submit" name="generate" value="Generate">
</form>

<?php
if (isset($_POST['generate'])) {
    $n = $_POST['num'];

    $first = 0;
    $second = 1;

    echo "<h3>Fibonacci Sequence:</h3>";

    if ($n >= 1) echo $first . " ";
    if ($n >= 2) echo $second . " ";

    for ($i = 2; $i < $n; $i++) {
        $next = $first + $second;
        echo $next . " ";

        $first = $second;
        $second = $next;
    }
}
?>

</body>
</html>
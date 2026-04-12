<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Prime Number</title>
</head>
<body>
    <form method="post">
    Enter Number: 
    <input type="number" name="num" id="num" required>
    <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    if (isset($_POST['submit'])) { 
        
        $num = $_POST['num'];
        $isPrime = true;

        if ($num == 1|| $num ==0) {
           echo "<h3> $num is NOT a Prime Number or Composite</h3>";
           return;
        } else {
            for ($i = 2; $i < ($num); $i++) {
                if (($num % $i) == 0) {
                    $isPrime = false;
                    break;    

                }
            }
        }

        if ($isPrime) {
            echo "<h3> $num is a Prime Number</h3>";
        } else{
            echo "<h3> $num is NOT a Prime Number </h3>";
        }
    }
    
    ?>
</body>
</html>
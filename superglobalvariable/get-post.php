<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action= "" method ="POST"> 
        <input type="text" name="fn">
        <input type="submit" value="submit">
</form>
    <?php 
$store = $_REQUEST['fn'];
echo "Name : ".$store;
?>

    
</body>
</html>
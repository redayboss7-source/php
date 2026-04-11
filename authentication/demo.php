<?php 
session_start();
if(!isset($_SESSION["rnam"])){
    header("location:log_in.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="other.php">other</a>
    <form>
        <div>Id<br/>
        <input type="text" name="txtId"/>
        </div>

        <div>Name<br/>
        <input type="text" name="txtName"/>
        </div>

        <div>Email<br/>
        <input type="text" name="Email"/>
        </div>

        <div>Phone<br/>
        <input type="text" name="txtPhone"/>
        </div>
        <div>
            <input type="Submit" name="Submit" />
        </div>
    </form>
    <a href="log_out.php">Logout</a>
</body>
</html>
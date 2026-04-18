<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}
?>

<link rel="stylesheet" href="style.css">

<h2 style="text-align:center;color:white;">Admin Panel</h2>

<table class="table">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Address</th>
<th>Contact</th>
<th>Username</th>
<th>Image</th>
</tr>

<?php
$file = file("data.txt");

foreach($file as $row){
    $data = explode("|", trim($row));

    echo "<tr>
        <td>$data[0]</td>
        <td>$data[1]</td>
        <td>$data[2]</td>
        <td>$data[4]</td>
        <td>$data[5]</td>
        <td>$data[6]</td>
        <td><img src='$data[7]' width='80'></td>
    </tr>";
}
?>
</table>

<div style="text-align:center;">
<a href="logout.php">Logout</a>
</div>
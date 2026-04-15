<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Website</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.card img{
  height:200px;
  object-fit:cover;
  transition:0.4s;
}
.card img:hover{
  transform:scale(1.1);
}
</style>

</head>
<body>

<div class="container py-3">

<h2>Welcome <?php echo $_SESSION["user"]; ?></h2>

<a href="upload.php">Upload</a> |
<a href="logout.php">Logout</a>

<hr>

<h3 class="text-center">📸 Uploaded Images</h3>

<div class="row">

<?php
$files = glob("uploads/*");

foreach($files as $file){
?>

<div class="col-md-3 mb-3">
<div class="card p-2">
<img src="<?php echo $file; ?>" class="img-fluid">
</div>
</div>

<?php } ?>

</div>

</div>

</body>
</html>
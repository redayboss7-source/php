<?php
session_start();

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit();
}

if(isset($_POST['upload'])){

    $file=$_FILES['file']['name'];
    $tmp=$_FILES['file']['tmp_name'];
    $ext=strtolower(pathinfo($file,PATHINFO_EXTENSION));

    if(($ext=="jpg" || $ext=="png") && $_FILES['file']['size']<=3*1024*1024){

        if(!is_dir("uploads")) mkdir("uploads");

        $newName=time().rand(1000,9999).".".$ext;

        move_uploaded_file($tmp,"uploads/".$newName);

        $msg="Uploaded!";
    }else{
        $msg="Invalid file!";
    }
}

if(isset($_GET['del'])){
    unlink("uploads/".$_GET['del']);
}
?>

<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-4">

<div class="d-flex justify-content-between mb-3">
<h4>Welcome <?php echo $_SESSION['user']; ?></h4>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

<div class="card p-3 mb-3">

<?php if(isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>

<form method="post" enctype="multipart/form-data">

<input type="file" name="file" class="form-control mb-2" required>

<button class="btn btn-primary" name="upload">Upload</button>

</form>

</div>

<div class="row">

<?php
$files=@scandir("uploads");

if($files){
foreach($files as $f){

if($f!="." && $f!=".."){
?>

<div class="col-md-3 mb-3">
<div class="card p-2">

<img src="uploads/<?php echo $f; ?>" class="img-fluid">

<a href="?del=<?php echo $f; ?>" class="btn btn-danger btn-sm mt-2">Delete</a>

</div>
</div>

<?php
}
}
}
?>

</div>

</div>

</body>
</html>
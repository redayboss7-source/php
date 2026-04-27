<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

/* UPLOAD */
if(isset($_POST['upload'])){

    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if(($ext == "jpg" || $ext == "png") && $size <= 3*1024*1024){

        if(!is_dir("uploads")){
            mkdir("uploads");
        }

        $newName = time().rand(1000,9999).".".$ext;

        move_uploaded_file($temp,"uploads/".$newName);

        $msg = "File Uploaded Successfully";

    }else{
        $error = "Only JPG/PNG & max 3MB allowed!";
    }
}

/* DELETE */
if(isset($_GET['delete'])){
    $delFile = "uploads/" . $_GET['delete'];

    if(file_exists($delFile)){
        unlink($delFile);
        $msg = "File Deleted!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
}

.card img{
    height:180px;
    object-fit:cover;
}
</style>

</head>

<body>

<div class="container mt-4">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow mb-4">
    <h5>Welcome, <?php echo $_SESSION['user']; ?></h5>
    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

<!-- UPLOAD BOX -->
<div class="card shadow mb-4">
    <div class="card-body text-center">

        <h4 class="mb-3">Upload Image</h4>

        <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="post" enctype="multipart/form-data">

            <input type="file" name="file" class="form-control mb-3" required>

            <button name="upload" class="btn btn-primary w-100">Upload</button>

        </form>

    </div>
</div>

<!-- GALLERY -->
<h4 class="text-white text-center mb-3">📸 Image Gallery</h4>

<div class="row">

<?php
$folder = "uploads/";

if(!is_dir($folder)){
    mkdir($folder);
}

$files = scandir($folder);

foreach($files as $file){

    if($file != "." && $file != ".."){
?>

<div class="col-md-3 mb-4">
    <div class="card shadow">

        <img src="uploads/<?php echo $file; ?>" class="card-img-top">

        <div class="card-body text-center">

            <a href="?delete=<?php echo $file; ?>" 
               class="btn btn-danger btn-sm"
               onclick="return confirm('Delete this file?')">
               Delete
            </a>

        </div>

    </div>
</div>

<?php
    }
}
?>

</div>

</div>

</body>
</html>
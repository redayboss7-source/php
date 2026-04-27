<?php
session_start();

if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit();
}

/* UPLOAD */
if(isset($_POST['upload'])){

    $title = trim($_POST['title']);
    $desc  = trim($_POST['desc']);

    $file = $_FILES['file']['name'];
    $tmp  = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','pdf','doc','docx'];

    if(!in_array($ext,$allowed)){
        $error = "Only JPG, PNG, PDF, DOC allowed!";
    }
    elseif($size > 3*1024*1024){
        $error = "Max file size 3MB!";
    }
    else{

        if(!is_dir("uploads")){
            mkdir("uploads");
        }

        $newName = uniqid().".".$ext;

        move_uploaded_file($tmp,"uploads/".$newName);

        // save title + desc
        $data = "$newName,$title,$desc\n";
        file_put_contents("fileinfo.txt",$data,FILE_APPEND);

        $msg = "File Uploaded!";
    }
}

/* DELETE */
if(isset($_GET['delete'])){
    $delFile = $_GET['delete'];
    $path = "uploads/".$delFile;

    if(file_exists($path)){
        unlink($path);
    }

    // remove from fileinfo.txt
    if(file_exists("fileinfo.txt")){
        $lines = file("fileinfo.txt");
        $newData = "";

        foreach($lines as $line){
            $row = explode(",", $line);
            if(trim($row[0]) != $delFile){
                $newData .= $line;
            }
        }

        file_put_contents("fileinfo.txt", $newData);
    }

    $msg = "File Deleted!";
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
.preview-img{
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

        <h4 class="mb-3">Upload File</h4>

        <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="post" enctype="multipart/form-data">

            <input type="text" name="title" class="form-control mb-2" placeholder="Enter Title">

            <textarea name="desc" class="form-control mb-3" placeholder="Enter Description"></textarea>

            <input type="file" name="file" class="form-control mb-3" required>

            <button name="upload" class="btn btn-primary w-100">Upload</button>

        </form>

    </div>
</div>

<!-- GALLERY -->
<h4 class="text-white text-center mb-3">📂 File Gallery</h4>

<div class="row">

<?php
$folder = "uploads/";

if(!is_dir($folder)){
    mkdir($folder);
}

$files = scandir($folder);

foreach($files as $f){

    if($f != "." && $f != ".."){

        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));

        // get title + desc
        $title = "";
        $desc = "";

        if(file_exists("fileinfo.txt")){
            $lines = file("fileinfo.txt");

            foreach($lines as $line){
                $row = explode(",", $line);

                if(trim($row[0]) == $f){
                    $title = $row[1];
                    $desc  = $row[2];
                }
            }
        }
?>

<div class="col-md-3">
<div class="card p-3 mb-4 text-center shadow">

<?php
// image preview only
if(in_array($ext,['jpg','jpeg','png'])){
?>
    <img src="uploads/<?php echo $f; ?>" class="img-fluid preview-img">
<?php
}
?>

<!-- TITLE -->
<p class="fw-bold text-primary mt-2"><?php echo $title; ?></p>

<!-- DESCRIPTION -->
<p class="text-muted"><?php echo $desc; ?></p>

<!-- FILE NAME -->
<p class="text-dark small"><?php echo $f; ?></p>

<!-- DELETE -->
<a href="?delete=<?php echo $f; ?>" 
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this file?')">
   Delete
</a>

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
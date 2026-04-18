<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>My Brand</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
  background:#f8f9fa;
}

.navbar-brand{
  font-weight:bold;
  letter-spacing:2px;
}

/* card */
.card{
  border:none;
  border-radius:10px;
  overflow:hidden;
  box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.card img{
  height:220px;
  object-fit:cover;
  transition:0.4s;
}

.card:hover img{
  transform:scale(1.1);
}

/* upload box */
.upload-box{
  background:white;
  padding:20px;
  border-radius:10px;
  box-shadow:0 4px 10px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<!-- 🔥 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">MY BRAND</a>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>

        <?php if(isset($_SESSION["user"])) { ?>

        <li class="nav-item">
          <a class="nav-link" href="#upload">Upload</a>
        </li>

        <li class="nav-item">
          <span class="nav-link text-warning">👤 <?php echo $_SESSION["user"]; ?></span>
        </li>

        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>

        <?php } else { ?>

        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>

        <?php } ?>

      </ul>
    </div>
  </div>
</nav>


<div class="container-fluid p-0">
  <img src="https://via.placeholder.com/1200x400" class="img-fluid w-100">
</div>

<div class="container py-5">


<?php if(!isset($_SESSION["user"])) { ?>
<div class="alert alert-warning text-center">
  Please login to upload images
</div>
<?php } ?>


<?php
if(isset($_SESSION["user"])){

if(isset($_POST['upload'])){

    $f = $_FILES['file'];

    $name = $f['name'];
    $tmp  = $f['tmp_name'];
    $size = $f['size'];

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    $allow = ['jpg','jpeg','png'];
    $max = 2*1024*1024;

    if(!in_array($ext,$allow)){
        $msg="❌ Invalid file type";
    }
    elseif($size>$max){
        $msg="❌ File too large";
    }
    else{
        $new = time()."_".$name;
        $path = "uploads/".$new;

        if(move_uploaded_file($tmp,$path)){
            $msg="✅ Upload Success";
        }else{
            $msg="❌ Upload Failed";
        }
    }
}
?>

<div id="upload" class="upload-box mb-5">
  <h4 class="mb-3">📤 Upload Image</h4>

  <?php if(isset($msg)) echo "<p>$msg</p>"; ?>

  <form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" class="form-control mb-3" required>
    <button type="submit" name="upload" class="btn btn-dark">Upload</button>
  </form>
</div>

<?php } ?>


<h3 class="text-center mb-4">📸 Uploaded Gallery</h3>

<div class="row">

<?php
$files = glob("uploads/*");

if($files){
foreach($files as $file){
?>

<div class="col-md-3 col-6 mb-4">
  <div class="card">
    <img src="<?php echo $file; ?>" class="img-fluid">
  </div>
</div>

<?php } } else { ?>

<p class="text-center">No images uploaded yet</p>

<?php } ?>

</div>

</div>


<footer class="bg-dark text-white text-center py-3">
  © 2026 My Brand | All Rights Reserved
</footer>

</body>
</html>
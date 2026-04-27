<?php
$connect = mysqli_connect("localhost", "root", "", "crud");
$data = mysqli_query($connect, "SELECT * FROM users");

 if(isset($_GET['viedit'])){
    $deleteid=$_GET['viedit'];


    $sql = "DELETE FROM users WHERE id= $deleteid";
    if(mysqli_query($connect,$sql)== TRUE){
        header('location: view.php');
    }
  }
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Users List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <a href="insert.php" class="btn btn-primary mb-3">Insert</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>id</th>
        <th>name</th>
        <th>contact</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>

    <?php while($row = mysqli_fetch_row($data)) { ?>
      <tr>
        <td><?php echo $row[0]; ?></td>
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td>
          <a href="edit.php?id=<?php echo $row[0]; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="view.php?viedit=<?php echo $row[0]; ?>" class="btn btn-danger btn-sm">Delete</a>
        </td>
      </tr>
    <?php } ?>

    </tbody>
  </table>
</div>
  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
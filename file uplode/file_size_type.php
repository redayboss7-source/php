<?php
if(isset($_POST['submit'])){

    $file = $_FILES['myfile'];


    $fileName = $file['name'];
    $fileTmp = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileType = $file['type'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

  
    $allowed = ['jpg', 'png', 'pdf'];

   
    $maxSize = 2 * 1024 * 1024;

    echo "<h3>File Info:</h3>";
    echo "Name: $fileName <br>";
    echo "Size: $fileSize bytes <br>";
    echo "Type: $fileType <br>";
    echo "Extension: $fileExt <br><br>";

    
    if(!in_array($fileExt, $allowed)){
        echo "❌ Invalid file type! শুধু jpg, png, pdf allowed <br>";
    }
    elseif($fileSize > $maxSize){
        echo "❌ File too large! Max 2MB <br>";
    }
    else{
        
        $uploadPath = "uplodes/" . $fileName;

        
        if(move_uploaded_file($fileTmp, $uploadPath)){
            echo "✅ File uploaded successfully!";
        } else {
            echo "❌ Upload failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
</head>
<body>

<h2>Upload File</h2>

<form method="POST" enctype="multipart/form-data">
    Select File: <input type="file" name="myfile" required><br><br>
    <input type="submit" name="submit" value="Upload">
</form>

</body>
</html>
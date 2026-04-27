<?php

$file=$_GET['file'];

$path="upload/".$file;

if(file_exists($path)){
unlink($path);
}

header("location:admin.php");

?>
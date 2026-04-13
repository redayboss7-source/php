<?php

    // encrypt with md5().

$pass = "userid0987";
$md5_method = md5($pass);
echo $md5_method;
echo "<br>";
echo strlen($md5_method);

echo "<br>";
echo "<br>";

 // encrypt with sha1().

$pass = "userid0987";
$sha1_method = sha1($pass);
echo $sha1_method;
echo "<br>";
echo strlen($sha1_method);

echo "<br>";
echo "<br>";

// encrypt with hash().
 

$hash_method = hash("sha256","user");
echo $hash_method;
echo "<br>";
echo strlen($hash_method);

echo "<br>";
echo "<br>";

 // encrypt with base64_encode().

 $pass = "userid0987";
 $base64_encode_method = base64_encode($pass);
 echo $base64_encode_method;
 echo "<br>";
 echo strlen($base64_encode_method);
 
 echo "<br>";
 echo "<br>";
 // encrypt with base64_decode().

 $base64_decode_method = base64_decode("dXNlcmlkMDk4Nw==");
 echo $base64_decode_method;

 echo "<br>";
 echo "<br>";


 
?>
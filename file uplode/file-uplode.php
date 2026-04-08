<?php
echo "File Name: " . $_FILES['filen']['name'];
echo "<br>";
echo "File Name: " . $_FILES['filen']['type'];
echo "<br>";
echo "File temporary name: " . $_FILES['filen']['tmp_name'];
echo "<br>";
echo "File error: " . $FILES['filen']['error'];
echo "<br>";
echo $_FILES['filen']['full path'];

?>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="filen">
<input type="submit">


</form>
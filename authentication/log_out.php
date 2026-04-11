<?php
session_start();
unset($_SESSION['rnam']);
session_destroy();
header("location:log_in.php");
?>
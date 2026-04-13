<?php
session_start();

if(isset($_SESSION["user"])){
    echo "OK";
}else{
    echo "LOGOUT";
}
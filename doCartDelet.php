<?php
session_start();
$count=$_POST["count"];
unset($_SESSION["cartArr"][$count]);
$_SESSION["cartArr"]=array_values($_SESSION["cartArr"]);
var_dump($_SESSION["cartArr"]);
header("location: cart.php");
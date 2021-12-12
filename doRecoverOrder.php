<?php
require_once ("../pdo_connect.php");

$orderID=$_POST["orderID"];

$sql="UPDATE order_detail SET orderStatusID=1 WHERE orderID=?";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute([$orderID]);
    header("location: owner_order_management.php");
}catch (PDOException $e){
    echo $e->getMessage();
}
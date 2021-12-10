<?php
require_once("../db-PDOconnect4project.php");

$orderID=$_POST["orderID"];

$sql="UPDATE order_detail SET orderStatusID=1 WHERE orderID=?";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute([$orderID]);
    
    header("location: customer_order.php");
}catch (PDOException $e){
    echo $e->getMessage();
}
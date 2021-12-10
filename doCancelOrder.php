<?php
require_once("../db-PDOconnect4project.php");

$orderID=$_POST["orderID"];

$sql="UPDATE order_detail SET orderStatusID=3 WHERE orderID=?";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute([$orderID]);
    echo "<script>alert('成功'); location.href = 'customer_order.php';</script>";
}catch (PDOException $e){
    echo $e->getMessage();
}
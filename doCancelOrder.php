<?php
// require_once ("../pdo_connect.php");
require_once("../db-PDOconnect4project.php");
$orderID=$_POST["orderID"];


if (isset($_SESSION["user"])) {
    $sql="UPDATE order_detail SET orderStatusID=3 WHERE orderID=?";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute([$orderID]);
    header("location: customer_order.php");
}catch (PDOException $e){
    echo $e->getMessage();
}

} elseif (isset($_SESSION["usercamp"])) {

$sql="UPDATE order_detail SET orderStatusID=3 WHERE orderID=?";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute([$orderID]);
    header("location: owner_order_management.php");
}catch (PDOException $e){
    echo $e->getMessage();
}
}
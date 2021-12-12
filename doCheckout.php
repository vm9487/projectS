<?php
// require_once ("../pdo_connect.php");
require_once("../db-PDOconnect4project.php");

$cart=$_SESSION["cartArr"];
$user=$_SESSION["user"];
$customerID=$user["customerID"];

foreach ($cart as $value){
    $campID=$value["campID"];
    $ppl=$value["ppl"];
    $startDate=$value["startDate"];
    $endDate=$value["endDate"];
    $now=date("Y-m-d H:i:s");

//    VALUE()中還要再修改為登入人的customerID
    $sql="INSERT INTO order_detail(customerID, numPpl, createdTime, orderDateStart, orderDateEnd, campID, orderStatusID) VALUE('$customerID', '$ppl', '$now', '$startDate', '$endDate', '$campID', '1')";
    $stmt=$db_host->prepare($sql);
    try{
        $stmt->execute();
        unset($_SESSION["cartArr"]);
        header("location: checkout_success.php");
    }catch (PDOException $e){
        echo "訂單送出錯誤";
        echo $e->getMessage();
    }
}
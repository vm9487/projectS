<?php
$name=$_POST["customerName"];
$account=$_POST["customerAccount"];
$gender=$_POST["customerGender"];
$birthday=$_POST["customerBday"];

require_once ("../db-connect.php");
$now=date("Y-m-d H:i:s");
//echo $now;
//exit;
$sql="INSERT INTO customer_list(customerAccount, customerName, customerGender, created_at, customerBday) VALUES('$account', '$name', '$gender', '$now', '$birthday')";

if ($conn->query($sql) === TRUE) {
    echo "新增資料完成<br>";
    $id=$conn->insert_id;
//    echo "id: $id";
    header("location: create_customer.php");
} else {
    echo "新增資料錯誤: " . $conn->error;
}
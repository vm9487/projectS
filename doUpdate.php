<?php
$name=$_POST["customerName"];
//  
$gender=$_POST["customerGender"];
$birthday=$_POST["customerBday"];
$customerID=$_POST["customerID"];
$picture=$_POST["customerPic"];


require_once ("../db-connect.php");
// $now=date("Y-m-d H:i:s");
//echo $now;
//exit;
// $sql="INSERT INTO customer_list(customerAccount, customerName, customerGender, created_at, customerBday) VALUES('$account', '$name', '$gender', '$now', '$birthday')";
$sql="UPDATE customer_list SET customerName='$name', customerBday='$birthday', customerGender='$gender', customerPic='$picture', WHERE customerID='$customerID'";

// exit();
if ($conn->query($sql) === TRUE) {
    echo "修改資料完成<br>";
//    echo "id: $id";
    header("location: customer-edit.php?customerID=".$customerID);
} else {
    echo "修改資料錯誤: " . $conn->error;
}
<?php
require_once ("../db-connect.php");

$customerID=$_GET["customerID"];

//$sql="DELETE FROM users WHERE id='$id'";
$sql="UPDATE customer_list SET customerValid=0 WHERE customerID='$customerID'";


if ($conn->query($sql) === TRUE) {
    echo "刪除資料完成<br>";
//    header("location: user-list.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

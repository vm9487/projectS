<?php
$name=$_POST["campOwnerName"];  
$birthday=$_POST["campOwnerBday"];
$phone=$_POST["campOwnerPhone"];
$company=$_POST["campOwnerCompanyName"];
$campOwnerID=$_POST["campOwnerID"];
// $picture=$_POST["customerPic"];


require_once ("../db-connect.php");
// $now=date("Y-m-d H:i:s");
//echo $now;
//exit;
// $sql="INSERT INTO customer_list(customerAccount, customerName, customerGender, created_at, customerBday) VALUES('$account', '$name', '$gender', '$now', '$birthday')";
$sql="UPDATE camp_owner_list SET campOwnerName='$name', campOwnerBday='$birthday', campOwnerPhone='$phone', campOwnerCompanyName='$company' WHERE campOwnerID='$campOwnerID'";

// exit();
if ($conn->query($sql) === TRUE) {
    echo "修改資料完成<br>";
//    echo "id: $id";
    header("location: campOwner-edit.php?campOwnerID=".$campOwnerID);
} else {
    echo "修改資料錯誤: " . $conn->error;
}
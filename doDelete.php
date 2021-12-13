<?php
require_once ("../db-connect.php");

$customerID=$_GET["customerID"];

$campOwnerID=$_GET["campOwnerID"];


if (isset($_GET["customerID"])) {

    //$sql="DELETE FROM users WHERE id='$id'";
$sql="UPDATE customer_list SET customerValid=0 WHERE customerID='$customerID'";


if ($conn->query($sql) === TRUE) {
    // echo "刪除資料完成<br>";
   header("location: customer-list.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}



} elseif ($_GET["campOwnerID"]) {
//$sql="DELETE FROM users WHERE id='$id'";
$sql="UPDATE camp_owner_list	
SET campOwnerValid
=0 WHERE campOwnerID
='$campOwnerID
'";


if ($conn->query($sql) === TRUE) {
    // echo "刪除資料完成<br>";
   header("location: campowner-list.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}


}


<?php


require_once("../db-connect.php");

$id = $_GET["id"];

//$sql="DELETE FROM users WHERE id='$id'";
$sql = "UPDATE camp_list SET campValid=0 WHERE campID='$id'";
if ($conn->query($sql) === TRUE) {
   // echo "刪除資料完成<br>";
    echo '<script>alert("刪除完成");location.href="camp-list.php"</script>';
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
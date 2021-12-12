<?php


$campName = $_POST["campName"];
$campPrice = $_POST["campPrice"];
$id = $_POST["id"];
$campCate1ID= $_POST["campCate1ID"];

$campRegionID = $_POST["campRegionID"];
$campCountyID =$_POST["campCountyID"];
$campDistID =$_POST["campDistID"];
$campAdd = $_POST["campAdd"];
$campCate3ID= $_POST["campCate3ID"];
$campNote = $_POST["campNote"];
$campDes = $_POST["campDes"];

require_once("../db-connect.php");
$sql = "UPDATE camp_list SET campName='$campName', campPrice='$campPrice', campCate1ID='$campCate1ID',campRegionID='$campRegionID',campCountyID='$campCountyID',campDistID='$campDistID',campAdd='$campAdd',campCate3ID='$campCate3ID',campNote='$campNote',campDes='$campDes' WHERE campID= '$id'";
if ($_FILES["myFile"]["error"] === 0 && move_uploaded_file($_FILES["myFile"]["tmp_name"], "upload/" . $_FILES["myFile"]["name"])) {

   // $now = date("Y-m-d H:i:s");
    $file_name = $_FILES["myFile"]["name"];
    $sql = "UPDATE camp_list SET campPic='$file_name' WHERE campID= '$id'";

//echo $sql;
}
//exit();
if ($conn->query($sql) === TRUE) {

    echo '<script language="JavaScript">;alert("修改完成");location.href="camp-list.php";</script>';


} else {
    echo "修改資料錯誤: " . $conn->error;
}

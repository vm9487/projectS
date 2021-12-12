<?php
require_once("../db-PDOconnect4project.php");

$campName = $_POST["campName"];
$campPrice = $_POST["campPrice"];
//$campPic = $_POST["campPic"];
$campCate1ID = $_POST["campCate1ID"];
$campRegionID = $_POST["campRegionID"];
$campCountyID =$_POST["campCountyID"];
$campDistID =$_POST["campDistID"];
$campAdd = $_POST["campAdd"];
//$campCate2ID = $_POST["campCate2ID"];
$campCate3ID = $_POST["campCate3ID"];
$campNote = $_POST["campNote"];
$campDes= $_POST["campDes"];

if (isset($_SESSION["usercamp"])) {
//    echo"usercamp";

    $id = $_SESSION["usercamp"]["campOwnerID"];


}
require_once("../db-connect.php");
//$now = date("Y-m-d H:i:s");
//echo $now;
//exit;
if ($_FILES["myFile"]["error"] === 0 && move_uploaded_file($_FILES["myFile"]["tmp_name"], "upload/" . $_FILES["myFile"]["name"])) {

    $now = date("Y-m-d H:i:s");
    $file_name = $_FILES["myFile"]["name"];

    $sql = "INSERT INTO camp_list(campOwnerID,campName,campPrice,campPic, campCate1ID, campRegionID,campCountyID,campDistID,campAdd,campNote, campCate3ID,campDes) VALUES('$id','$campName','$campPrice','$file_name', '$campCate1ID', '$campRegionID','$campCountyID', '$campDistID','$campAdd','$campNote','$campCate3ID','$campDes')";
}

if ($conn->query($sql) === TRUE) {
    //echo "營地上架完成<br>";

    echo '<script language="JavaScript">;alert("上架完成");location.href="camp-list.php";</script>';
  //  $id = $conn->insert_id;
//    echo "id: $id";
   // header("location: camp-list.php?id=" . $id);
} else {
    echo '<script language="JavaScript">;alert("上架失敗");location.href="camp-list.php";</script>' . $conn->error;
}
?>


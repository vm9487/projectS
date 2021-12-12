<?php
require_once("../db-PDOconnect4project.php");

//var_dump($_SESSION["usercamp"]["campOwnerID"]);
///////////////////////////////////////////////////////////////////////////////////
//$account=$_POST["account"];
if (isset($_SESSION["user"])){
    $id = $_SESSION["user"]["customerID"];
}
elseif (isset($_SESSION["usercamp"])){
    $id = $_SESSION["usercamp"]["campOwnerID"];
}

$name=$_POST["name"];
$gender=$_POST["gender"];
$bday=$_POST["Birthday"];
$phone=$_POST["Phone"];
$password=$_POST['password'];
$repassword=$_POST['repassword'];
if($password!==$repassword){
    echo "<script>window.alert('密碼不相同，請重新輸入');location.href='p-profile.php.php';</script>";
    exit();
}
//$password=md5($password);
if (isset($_SESSION["user"])){
    $sql = "UPDATE `customer_list` SET `customerPhone` = ?, `customerPassword`= ? ,`customerName` = ?, `customerBday`= ?, `customerGender`= ? WHERE `customerID` = ? ";
}
elseif (isset($_SESSION["usercamp"])){
    $sql = "UPDATE `camp_owner_list` SET `campOwnerPhone` = ?, `campOwnerPassword`= ? ,`campOwnerName` = ?, `campOwnerBday`= ?, `campOwnerGender`= ? WHERE `campOwnerID` = ? ";
}

$stmt =$db_host->prepare($sql);
$stmt->bindParam(1, $phone);
$stmt->bindParam(2, $password);
$stmt->bindParam(3, $name);
$stmt->bindParam(4, $bday);
$stmt->bindParam(5, $gender);
$stmt->bindParam(6, $id);
//$stmt->bindParam(7, $id);
$result = $stmt->execute();

//------------------------------------------------------------------------------
//$sql="UPDATE camp_owner_list SET `campOwnerPhone`=:campOwnerPhone WHERE `campOwnerID` =:campOwnerID";
////campOwnerGender=:campOwnerGender,campOwnerPassword=:campOwnerPassword,campOwnerName=:campOwnerName,campOwnerBday=:campOwnerBday,
//    $stmt =$db_host->prepare($sql);
//$data=['campOwnerPhone'=>'$phone','campOwnerID '=>'$id'];
////'campOwnerGender'=>'$gender','campOwnerPassword'=>'$password','campOwnerName'=>'$name','campOwnerBday'=>'$bday',
////    $stmt->bindParam(':campOwnerPassword', $data['campOwnerPassword'],PDO::PARAM_STR);
////    $stmt->bindParam(':campOwnerName', $data['campOwnerName'],PDO::PARAM_STR);
//////    $stmt->bindParam(':campOwnerGender',$data['campOwnerGender'],PDO::PARAM_STR);
////    $stmt->bindParam(':campOwnerBday', $data['campOwnerBday'],PDO::PARAM_STR);
//    $stmt->bindParam(':campOwnerPhone', $data['campOwnerPhone'],PDO::PARAM_STR);
//    $stmt->bindParam(':campOwnerID', $data['campOwnerID '],PDO::PARAM_STR);
//------------------------------------------------------------------------------

if($stmt->execute())
{
    //成功会返回受影响的记录数
//    echo '<h3>更新了</h3>';
    header("location: p-profile.php");
}else{
    echo '<h3>更新失败</h3>';
    print_r($stmt->errorInfo());
    die();
}



?>
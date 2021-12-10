<?php
require_once("../db-PDOconnect4project.php");

$now=date("y-m-d H:i:s");

$account=$_POST["account"];
$name=$_POST["name"];
$gender=$_POST["gender"];
$bday=$_POST["Birthday"];
$phone=$_POST["Phone"];
$password=$_POST['password'];
$repassword=$_POST['repassword'];
if($password!==$repassword){
    echo "<script>window.alert('密碼不相同，請重新註冊');location.href='p-signiupmainpageCampowner.php';</script>";
    exit();
}
//$password=md5($password);


$sqlCheck="SELECT * FROM camp_owner_list WHERE campOwnerAccount= ?";
$stmtCheck = $db_host->prepare($sqlCheck);

$stmtCheck->execute([$account]);
$userExist=$stmtCheck->rowCount();
//        echo $userExist."yes";
if($userExist>0){
//    echo "帳號已存在，請重新登入";
    echo "<script>window.alert('帳號已存在，前往登入頁面');location.href='p-login.php';</script>";
    exit();

}elseif($userExist===0){
$sql="INSERT INTO camp_owner_list (campOwnerAccount,campOwnerPassword,campOwnerName,campOwnerGender,campOwnerBday,campOwnerPhone,campOwnerCreatedTime) VALUES (?, ?,?, ?,?, ?,?)";
    $stmt =$db_host->prepare($sql);
$stmt->bindParam(1, $account);
$stmt->bindParam(2, $password);
    $stmt->bindParam(3, $name);
    $stmt->bindParam(4, $gender);
    $stmt->bindParam(5, $bday);
    $stmt->bindParam(6, $phone);
    $stmt->bindParam(7, $now);

$stmt->execute();
$signupcheck=$stmt->rowCount();
//echo $signupcheck;

     if ($signupcheck === 1) {



//          echo "註冊成功<br>";
//         header("location: p-dashboard.php");
         echo "<script>window.alert('註冊成功，請重新登入');location.href='p-login.php';</script>";
     }else{
         echo "註冊失敗signupcheck !=true";}


} else {echo "user_exist錯誤 " ;}















?>
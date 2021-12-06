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
    echo "passwords are different";
    exit();
}
//$password=md5($password);

$sqlCheck="SELECT * FROM camp_owner_list WHERE campOwnerAccount= ? AND 	campOwnerPassword= ?";
$stmtCheck = $db_host->prepare($sqlCheck);

$stmtCheck->execute([$account, $password]);
$userExist=$stmtCheck->rowCount();
        echo $userExist."yes";
if($userExist>0){
//    echo "帳號已存在，請重新登入";
    echo "<script>window.alert('帳號已存在，前往登入頁面');location.href='p-login.php';</script>";
    exit();

}elseif($userExist===0){
//echo "here";
    $sql="INSERT INTO camp_owner_list(campOwnerAccount,campOwnerPassword) VALUES(?,?)";
    try {
        $stmt = $db_host->prepare($sql);
        $stmt->bind_param("ss",$account,$password);
//        $result = $stmt->get_result();
//        $signupcheck=$stmt->query($sql);
        $stmt->execute();
//        echo $signupcheck."ok";
    } catch (PDOException $e) {
    echo $e->getMessage();
        echo "stmt錯誤";}

    if ($signupcheck === TRUE) {
        echo "註冊成功<br>";
        $id = $stmt->insert_id;

//        header("location: p-dashboard.php");
        echo "<script>window.alert('註冊成功，前往後臺首頁');location.href='p-dashboard.php';</script>";
    }else{
        echo "註冊失敗signupcheck !=true";}


} else {echo "userexist錯誤 " ;}















?>
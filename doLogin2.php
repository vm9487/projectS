<?php
require_once("../db-PDOconnect4project.php");

if(isset($_POST["email"])){
    $email=$_POST["email"];
    $password=$_POST["password"];
//var_dump($password);

}else{
//    echo " failure";
    exit();
}

//$password=md5($password);
///////////////////////////////////////////////////////////////
$sqlcustomer="SELECT * FROM customer_list WHERE customerAccount=? AND customerPassword=? AND customerValid
=1";
$stmtcustomer = $db_host->prepare($sqlcustomer);

$sqlCampOwner="SELECT * FROM camp_owner_list WHERE campOwnerAccount=? AND campOwnerPassword=? AND campOwnerValid
=1";
$stmtCampOwner = $db_host->prepare($sqlCampOwner);

try {
    $stmtcustomer->execute([$email, $password]);
    $userExistcustomer=$stmtcustomer->rowCount();
    $stmtCampOwner->execute([$email, $password]);
    $userExistCampOwner=$stmtCampOwner->rowCount();
//        echo $userExist."yes";
    if($userExistcustomer>0){
        $rowcustomer=$stmtcustomer->fetch();
        $usercustomer=[
            "customerID"=>$rowcustomer["customerID"],
            "customerAccount"=>$rowcustomer["customerAccount"],
            "customerName"=>$rowcustomer["customerName"],
        ];
        $_SESSION["user"]=$usercustomer;
        unset($_SESSION["error_time"]);
        unset($_SESSION["error_message"]);
        var_dump($_SESSION["user"]);
        header("Refresh:3;url=p-dashboard.php");
    }elseif($userExistCampOwner>0){
        $rowCampOwner=$stmtCampOwner->fetch();
        $userCampOwner=[
            "campOwnerID"=>$rowCampOwner["campOwnerID"],
            "campOwnerAccount"=>$rowCampOwner["campOwnerAccount"],
            "campOwnerName"=>$rowCampOwner["campOwnerName"],
        ];
        $_SESSION["user"]=$userCampOwner;
        unset($_SESSION["error_time"]);
        unset($_SESSION["error_message"]);
                var_dump($_SESSION["user"]);
        header("Refresh:3;url=p-dashboard.php");


    }else{
        $_SESSION["error_msg"]="帳號密碼錯誤";
        if(isset($_SESSION["error_time"])){
            $_SESSION["error_time"]=$_SESSION["error_time"]+1;
        }else{
            $_SESSION["error_time"]=1;
        }
//        echo($_SESSION["error_msg"]);
//        echo($_SESSION["error_time"]);
        header("location:p-login.php");


    }

    ///////////////////////////////////////////////
} catch (PDOException $e) {
    echo $e->getMessage();
}
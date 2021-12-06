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
$sql="SELECT * FROM customer_list WHERE customerAccount=? AND customerPassword=? AND customerValid
=1";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute([$email, $password]);
    $userExist=$stmt->rowCount();
//        echo $userExist."yes";
    ///////////////////////////////////////
    if($userExist>0){
        $row=$stmt->fetch();
        $user=[
            "customerID"=>$row["customerID"],
            "customerAccount"=>$row["customerAccount"],
            "customerName"=>$row["customerName"],
        ];

        $_SESSION["user"]=$user;
        unset($_SESSION["error_time"]);
        unset($_SESSION["error_message"]);
//        var_dump($_SESSION["user"]);
        header("location: p-dashboard.php");
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
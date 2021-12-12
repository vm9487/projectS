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

$sqlsuper="SELECT * FROM superadmin_list WHERE superadminAccount=? AND superadminPassword=?";
$stmtsuper = $db_host->prepare($sqlsuper);
// echo $_SESSION["toContinue"];

if(isset($_SESSION["toContinue"])){
    try {
        $stmtcustomer->execute([$email, $password]);
        $userExistcustomer=$stmtcustomer->rowCount();
    
        $stmtCampOwner->execute([$email, $password]);
        $userExistCampOwner=$stmtCampOwner->rowCount();
    
        $stmtsuper->execute([$email, $password]);
        $userExistsuper=$stmtsuper->rowCount();
    
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
            unset($_SESSION["toContinue"]);
    //        var_dump($_SESSION["user"]);
            echo "登入成功，將自動跳轉業面";
            header("Refresh:3;url=product_list.php");
    
    
        }elseif($userExistCampOwner>0){
            $rowCampOwner=$stmtCampOwner->fetch();
            $userCampOwner=[
                "campOwnerID"=>$rowCampOwner["campOwnerID"],
                "campOwnerAccount"=>$rowCampOwner["campOwnerAccount"],
                "campOwnerName"=>$rowCampOwner["campOwnerName"],
            ];
            $_SESSION["usercamp"]=$userCampOwner;
            unset($_SESSION["error_time"]);
            unset($_SESSION["error_message"]);
            unset($_SESSION["toContinue"]);
    //                var_dump($_SESSION["user"]);
            echo "您需要以customer帳號登入";
            header("Refresh:3;url=doLogout.php");
    
        }elseif($userExistsuper>0){
    
            $rowsuper=$stmtsuper->fetch();
            $usersuper=[
    
                "superadminAccount"=>$rowsuper["superadminAccount"],
            ];
            $_SESSION["usersuper"]=$usersuper;
            unset($_SESSION["error_time"]);
            unset($_SESSION["error_message"]);
            unset($_SESSION["toContinue"]);
    //                var_dump($_SESSION["user"]);
            echo "您需要以customer帳號登入";
            header("Refresh:3;url=doLogout.php");
    
    
    
    
    
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
            
}else{
    try {
        $stmtcustomer->execute([$email, $password]);
        $userExistcustomer=$stmtcustomer->rowCount();
    
        $stmtCampOwner->execute([$email, $password]);
        $userExistCampOwner=$stmtCampOwner->rowCount();
    
        $stmtsuper->execute([$email, $password]);
        $userExistsuper=$stmtsuper->rowCount();
    
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
    //        var_dump($_SESSION["user"]);
            echo "登入成功，將自動跳轉業面";
            header("Refresh:3;url=p-dashboard2.php");
    
    
        }elseif($userExistCampOwner>0){
            $rowCampOwner=$stmtCampOwner->fetch();
            $userCampOwner=[
                "campOwnerID"=>$rowCampOwner["campOwnerID"],
                "campOwnerAccount"=>$rowCampOwner["campOwnerAccount"],
                "campOwnerName"=>$rowCampOwner["campOwnerName"],
            ];
            $_SESSION["usercamp"]=$userCampOwner;
            unset($_SESSION["error_time"]);
            unset($_SESSION["error_message"]);
    //                var_dump($_SESSION["user"]);
            echo "登入成功，將自動跳轉業面";
            header("Refresh:3;url=p-dashboard2.php");
    
        }elseif($userExistsuper>0){
    
            $rowsuper=$stmtsuper->fetch();
            $usersuper=[
    
                "superadminAccount"=>$rowsuper["superadminAccount"],
            ];
            $_SESSION["usersuper"]=$usersuper;
            unset($_SESSION["error_time"]);
            unset($_SESSION["error_message"]);
    //                var_dump($_SESSION["user"]);
            echo "登入成功，將自動跳轉業面";
            header("Refresh:3;url=p-dashboard2.php");
    
    
    
    
    
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
}


<?php
// require_once ("../pdo_connect.php");
require_once("../db-PDOconnect4project.php");

//$startDate=$_POST["startDate"];
//$endDate=$_POST["endDate"];
$ppl=$_POST["ppl"];
$campID=$_POST["campID"];
$campName=$_POST["campName"];
$daterange=$_POST["daterange"];
$daterange=explode(' - ',$daterange);
$startDate=$daterange[0];
$endDate=$daterange[1];

if (!isset($_SESSION["cartArr"])){
    $cartArr=[
        array(
            "campID"=>$campID,
            "campName"=>$campName,
            "ppl"=>$ppl,
            "startDate"=>$startDate,
            "endDate"=>$endDate
        )
    ];
    $_SESSION["cartArr"]=$cartArr;
}else{
    $cartArr = $_SESSION["cartArr"];
    array_push($cartArr, array(
            "campID"=>$campID,
            "campName"=>$campName,
            "ppl"=>$ppl,
            "startDate"=>$startDate,
            "endDate"=>$endDate
        )
    );
    $_SESSION["cartArr"]=$cartArr;
}

header("location: cart.php");
?>
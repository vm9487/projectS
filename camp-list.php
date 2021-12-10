<?php
require_once("../db-PDOconnect4project.php");
if ((isset($_SESSION["user"])) or (isset($_SESSION["usercamp"])) or (isset($_SESSION["usersuper"]))) {
//    var_dump($_SESSION["user"]);
//    var_dump($_SESSION["user"]["customerID"]);
//    var_dump($_SESSION["usercamp"]);
//    var_dump($_SESSION["usersuper"]);
} else {
    header("location: p-login.php");
}

///////////////////////////////////////////////////////////////////////
if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"]["customerID"];
    $sqlIncomingorder = "SELECT * FROM order_detail WHERE customerID=? AND orderStatusID=1 AND DATE(orderDateStart) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) ";
    $stmtIncomingorder = $db_host->prepare($sqlIncomingorder);

//    print_r($time) ;
//    $nextWeek = time()+(7 * 24 * 60 * 60);
//    echo(date("Y-m-d",$nextWeek));
//    echo(date("Y-m-d",$t));
    try {
        $stmtIncomingorder->execute([$id]);
        $rowIncomingorder = $stmtIncomingorder->rowCount();
        $row2Incomingorder = $stmtIncomingorder->fetchAll(PDO::FETCH_ASSOC);
//
//        foreach ($row2Incomingorder as $value){
//         echo   ($value["orderDateStart"]);
//        }

//
//        foreach($row2Incomingorder as $row){
//            foreach($row as $key => $value){
//                print_r( $row["orderDateStart"]);
////                echo $key." : ".$value."<br />";
//}}



    } catch (PDOException $e) {
        echo $e->getMessage();
    };
////////////

    $sqlheadpic = "SELECT upload_headpic.*, customer_list.customerID  
FROM customer_list JOIN upload_headpic 
    ON customer_list.customerID=upload_headpic.customerID
WHERE customer_list.customerID=? ORDER BY headpicID DESC";
    $stmtheadpic = $db_host->prepare($sqlheadpic);
    try {
        $stmtheadpic->execute([$id]);
        $rowheadpic = $stmtheadpic->fetch();
//    var_dump($rowheadpic["customerPic"]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    };

} elseif (isset($_SESSION["usercamp"])) {
//    echo"usercamp";

    $id = $_SESSION["usercamp"]["campOwnerID"];
    $sqlIncomingorderc = "SELECT order_detail.*, camp_list.* 
FROM order_detail JOIN camp_list ON order_detail.campID=camp_list.campID
WHERE camp_list.campOwnerID=? AND orderStatusID=1 AND DATE(orderDateStart) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
    $stmtIncomingorderc = $db_host->prepare($sqlIncomingorderc);
    try {
        $stmtIncomingorderc->execute([$id]);
        $rowIncomingorderc = $stmtIncomingorderc->rowCount();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
////////////////////////////////////////////////////////////////////
    $sqlheadpicb = "SELECT upload_headpic.*, camp_owner_list.campOwnerID  
FROM camp_owner_list JOIN upload_headpic 
    ON camp_owner_list.campOwnerID=upload_headpic.campOwnerID
WHERE camp_owner_list.campOwnerID=? ORDER BY headpicID DESC";
    $stmtheadpicb = $db_host->prepare($sqlheadpicb);
    try {
        $stmtheadpicb->execute([$id]);
        $rowheadpicb = $stmtheadpicb->fetch();
//    var_dump($rowheadpicb["headpicFilename"]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    };

} elseif (isset($_SESSION["usersuper"])) {
//    echo"super";

} else {
    echo "nothing";

};
////////////////////////////////////////////////////////////////////////

require_once("../db-connect.php");
$sql = "SELECT * FROM camp_list WHERE campValid=1 ";



$sqlCampcate1 = "SELECT * FROM campcate1";
$resultCampcate1 = $conn->query($sqlCampcate1);
$Campcate1Arr = [];
while ($row = $resultCampcate1->fetch_assoc()) {
    $Campcate1Arr[$row["campCate1ID"]] = $row["campCate1item"];
}

$sqlCampcounty1 = "SELECT * FROM camp_county WHERE campRegionID = 1";
$resultCampcounty1 = $conn->query($sqlCampcounty1);
$Campcounty1Arr = [];
while ($row = $resultCampcounty1->fetch_assoc()) {
    $Campcounty1Arr[$row["campCountyID"]] = $row["campCounty"];
}

$sqlCampcounty2 = "SELECT * FROM camp_county WHERE campRegionID = 2";
$resultCampcounty2 = $conn->query($sqlCampcounty2);
$Campcounty2Arr = [];
while ($row = $resultCampcounty2->fetch_assoc()) {
    $Campcounty2Arr[$row["campCountyID"]] = $row["campCounty"];
}

$sqlCampcounty3 = "SELECT * FROM camp_county WHERE campRegionID = 3";
$resultCampcounty3 = $conn->query($sqlCampcounty3);
$Campcounty3Arr = [];
while ($row = $resultCampcounty3->fetch_assoc()) {
    $Campcounty3Arr[$row["campCountyID"]] = $row["campCounty"];
}

$sqlCampcounty4 = "SELECT * FROM camp_county WHERE campRegionID = 4";
$resultCampcounty4 = $conn->query($sqlCampcounty4);
$Campcounty4Arr = [];
while ($row = $resultCampcounty4->fetch_assoc()) {
    $Campcounty4Arr[$row["campCountyID"]] = $row["campCounty"];
}

$sqlCampcate3 = "SELECT * FROM campcate3";
$resultCampcate3 = $conn->query($sqlCampcate3);
$Campcate3Arr = [];
while ($row = $resultCampcate3->fetch_assoc()) {
    $Campcate3Arr[$row["campCate3ID"]] = $row["campCate3item"];
}
$sqlCampregion = "SELECT * FROM camp_region";
$resultCampregion = $conn->query($sqlCampregion);
$CampregionArr = [];
while ($row = $resultCampregion->fetch_assoc()) {
    $CampregionArr[$row["campRegionID"]] = $row["campRegion"];
}


$sqlcounty = "SELECT * FROM camp_county ";
$resultcounty = $conn->query($sqlcounty);
$CampcountyArr = [];
while ($row = $resultcounty->fetch_assoc()) {
    $CampcountyArr[$row["campCountyID"]] = $row["campCounty"];
}

$sqldist = "SELECT * FROM camp_dist ";
$resultdist = $conn->query($sqldist);
$CampdistArr = [];
while ($row = $resultdist->fetch_assoc()) {
    $CampdistArr[$row["campDistID"]] = $row["campDist"];
}


if (isset($_GET["cate1"])) {
    $cate1 = $_GET["cate1"];

    $sql = "SELECT * FROM camp_list  WHERE campCate1ID = '$cate1' AND campValid=1";


} elseif (isset($_GET["cate3"])) {
    $cate3 = $_GET["cate3"];
    $sql = "SELECT * FROM camp_list WHERE campCate3ID = '$cate3' AND campValid=1 ";
} elseif (isset($_GET["region"])) {
    $region = $_GET["region"];
    $sql = "SELECT * FROM camp_list WHERE campCountyID  = '$region' AND campValid=1 ";
}

if (isset($_GET["bigregion"])) {
    $bigregion = $_GET["bigregion"];
    $sql = "SELECT * FROM camp_list WHERE campRegionID = '$bigregion' AND campValid=1 ";
}

if (isset($_GET["order"])) {
    $order = $_GET["order"];

    if ($order === "priceAsc") {
        $sql = "SELECT * FROM camp_list WHERE campValid=1 ORDER BY campPrice ASC";
    } else if ($order === "priceDesc") {
        $sql = "SELECT * FROM camp_list WHERE campValid=1 ORDER BY campPrice DESC";
    }
}else if (isset($_GET["s"])) {
    $search = $_GET["s"];
    $sql = "SELECT * FROM camp_list WHERE campName LIKE '%$search%' OR campDes LIKE '%$search%' OR campNote LIKE '%$search%' OR campAdd LIKE '%$search%'";
}


$result = $conn->query($sql);
$campCount = $result->num_rows;
?>


<!doctype html>
<html lang="en">

<head>
    <title>Frame</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<style>
    .coverfit {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    :root {
        --bgcolor: rgb(147, 204, 192);
        --acolor: rgba(61, 134, 112, 0.863);
        --asidecolor: rgb(66, 168, 143);
    }

    .headera {
        background: var(--bgcolor);
    }

    .logo {
        width: 250px;
        height: 50px;

    }

    nav a {
        text-decoration: none;
        color: var(--acolor);

    }

    .headpic {
        width: 50px;
        height: 100%;
        border-radius: 50%;

    }

    .headbox {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        padding: 2px;
        border: 8px solid var(--bgcolor);

    <?php if (isset($_SESSION["user"])): ?>

    <?php if(isset($rowheadpic["headpicFilename"])):?>
        background:  url("upload/<?=$rowheadpic["headpicFilename"]?>");
    <?php else: ?>
        background:  url("img/pepe.png");
    <?php endif; ?>

    <?php elseif (isset($_SESSION["usercamp"])): ?>

    <?php if(isset($rowheadpicb["headpicFilename"])):?>
        background:  url("upload/<?=$rowheadpicb["headpicFilename"]?>");
    <?php else: ?>
        background:  url("img/pepe.png");
    <?php endif; ?>

    <?php elseif (isset($_SESSION["usersuper"])):  ?>
        background:  url("img/pepe.png");
    <?php else: ?>

    <?php endif; ?>



        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        transition: 0.5s;

    }

    .headbox:hover {
    <?php if (isset($_SESSION["user"])): ?>

    <?php if(isset($rowheadpic["headpicFilename"])):?>
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 10%,
        var(--asidecolor)), url("upload/<?=$rowheadpic["headpicFilename"]?>");
    <?php else: ?>
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 10%,
        var(--asidecolor)), url("img/pepe.png");
    <?php endif; ?>

    <?php elseif (isset($_SESSION["usercamp"])): ?>

    <?php if(isset($rowheadpicb["headpicFilename"])):?>
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 10%,
        var(--asidecolor)), url("upload/<?=$rowheadpicb["headpicFilename"]?>");
    <?php else: ?>
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 10%,
        var(--asidecolor)), url("img/pepe.png");
    <?php endif; ?>

    <?php elseif (isset($_SESSION["usersuper"])):  ?>
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 10%,
        var(--asidecolor)), url("img/pepe.png");
    <?php else: ?>

    <?php endif; ?>
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        cursor: pointer;
    }

    .changepic {
        margin: 120px 0px 0px 0px;
        text-decoration: none;
        display: flex;
        width: 180px;
        /*height: 200px;*/
        padding: 0px;
        color: whitesmoke;
        justify-content: center;
        align-items: end;
    }

    .changepic:hover {
        text-decoration: none;
        color: whitesmoke;
    }

    aside {
        background-color: var(--asidecolor);
        min-height: 100vw;
    }

    .block {
        background: whitesmoke;
        border-radius: 0 20px 20px 0px;
        color: var(--acolor);
        text-decoration: none;

    }


    .hello {
        color: var(--asidecolor);
        font-weight: bold;
        font-size: 30px;
        margin-left: 30px;
    }

    .remind {

        font-weight: bold;
        font-size: 30px;
        margin-left: 30px;
        background-color: var(--asidecolor);
        border-radius: 5px;
        padding: 5px;

    }

    .remind a {
        text-decoration: none;
        color: whitesmoke;
    }

    .displayh {
        display: none;
    }

    .welcomes {
        font-weight: bold;
        font-size: 30px;
        margin-left: 30px;
        color: var(--asidecolor);
    }
    .coverfit {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    :root {
        --bgcolor: rgb(147, 204, 192);
        --acolor: rgba(61, 134, 112, 0.863);
        --asidecolor: rgb(66, 168, 143);
    }

    .headera {
        background: var(--bgcolor);
    }

    .logo {
        width: 250px;
        height: 50px;

    }

    nav a {
        text-decoration: none;
        color: var(--acolor);

    }

    .headpic {
        width: 50px;
        height: 100%;
        border-radius: 50%;

    }

    aside {
        background-color: var(--asidecolor);
        min-height: 100vw;
    }

    .block {
        background: whitesmoke;
        border-radius: 0 20px 20px 0px;
        color: var(--acolor)
    }

    .cover-fit {
        width: 256px;
        height: 128px;
        object-fit: cover;

    }



    .price a.active{

        color:  #0d6efd;

    }
    .price a{
        background: white;
        padding: 10px 20px;
        text-decoration: none;
        color:  #333;
    }
    .block li a {
        display: block;
        padding: 10px 20px;
        text-decoration: none;
        color: #333;
        border-bottom: 1px solid #ccc;
    }

    .block li:hover a {
        background: #fff;
        border-radius: 0 20px 20px 0px;

    }

    .block li.active a {
        background: #0d6efd;
        color: #fff;
        border-radius: 0 20px 20px 0px;
    }


</style>

<body>
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 headera d-flex p-3 justify-content-between">
                <div class="logo ">
                    <img class="coverfit" src="./img/logo1.png" alt="logo">
                </div>
                <nav class=" ">
                    <?php if (isset($_SESSION["user"])): ?>
                        <a href=""><?= $_SESSION["user"]["customerName"] ?></a>
                    <?php elseif (isset($_SESSION["usercamp"])): ?>
                        <a href=""><?= $_SESSION["usercamp"]["campOwnerName"] ?></a>
                    <?php elseif (isset($_SESSION["usersuper"])): ?>
                        <a href=""><?= $_SESSION["usersuper"]["superadminAccount"] ?></a>
                    <?php else: ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION["user"])): ?>

                        <?php if(isset($rowheadpic["headpicFilename"])):?>
                            <img class="coverfit headpic mx-2" src="upload/<?= $rowheadpic["headpicFilename"] ?>"
                                 alt="pepethefrog">
                        <?php else: ?>
                            <img class="coverfit headpic mx-2" src="./img/pepe.png" alt="pepethefrog">
                        <?php endif; ?>



                    <?php elseif (isset($_SESSION["usercamp"])): ?>
                        <?php if(isset($rowheadpicb["headpicFilename"])):?>
                            <img class="coverfit headpic mx-2" src="upload/<?= $rowheadpicb["headpicFilename"] ?>" alt="pepethefrog">
                        <?php else: ?>
                            <img class="coverfit headpic mx-2" src="./img/pepe.png" alt="pepethefrog">
                        <?php endif; ?>
                    <?php elseif (isset($_SESSION["usersuper"])): ?>
                        <img class="coverfit headpic mx-2" src="./img/pepe.png" alt="pepethefrog">
                    <?php else: ?>
                    <?php endif; ?>

                    <a href="product_list.php">回網站首頁</a>
                </nav>
            </div>
        </div><!-- row -->
    </div><!-- container -->
</header>

<div class="mainsection">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 p-0">
                <aside class="px-2 py-2">
                    <?php if (isset($_SESSION["user"])): ?>
                        <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                        <div class="accordion" id="accordionExample">

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading4">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        個人資料
                                    </button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="p-profile.php" class="list-group-item list-group-item-action">個人資料維護</a>
                                            <a href="#" class="list-group-item list-group-item-action">聯絡官方</a>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingone">
                                    <a href="p-dashboard2.php" class=" block py-2 my-2 accordion-button collapsed" type="button">
                                        管理首頁
                                    </a>
                                </h2>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <a href="customer_order.php" class=" block py-2 my-2 accordion-button collapsed" type="button" ">
                                    你的訂單
                                    </a>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="#" class="list-group-item list-group-item-action">營地訂單</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->

                    <?php elseif (isset($_SESSION["usercamp"])): ?>
                        <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                        <div class="accordion" id="accordionExample">

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading4">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        個人資料
                                    </button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="p-profile.php" class="list-group-item list-group-item-action">個人資料維護</a>
                                            <a href="#" class="list-group-item list-group-item-action">聯絡官方</a>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingone">
                                    <a href="p-dashboard2.php" class=" block py-2 my-2 accordion-button collapsed" type="button">
                                        管理首頁
                                    </a>
                                </h2>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        營地訂單
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="owner_order_management.php" class="list-group-item list-group-item-action">訂單總覽</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                        業績檢視
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="p-biz.php" class="list-group-item list-group-item-action">業績首頁</a>
                                            <a href="p-monthlybiz.php" class="list-group-item list-group-item-action">每月業績展現</a>
                                            <a href="p-futurebiz.php" class="list-group-item list-group-item-action">未來業績展現</a>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->                                     <div class="accordion-item">
                                <h2 class="accordion-header" id="heading5">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                        營地管理
                                    </button>
                                </h2>
                                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="camp-list.php" class="list-group-item list-group-item-action">營地列表</a>
                                            <a href="camp-add.php" class="list-group-item list-group-item-action">營地上架</a>



                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->

                    <?php elseif (isset($_SESSION["usersuper"])): ?>
                        <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                        <div class="accordion" id="accordionExample">


                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingone">
                                    <a href="p-dashboard2.php" class=" block py-2 my-2 accordion-button collapsed" type="button" >
                                        管理首頁
                                    </a>
                                </h2>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        顧客管理
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="customer-list.php" class="list-group-item list-group-item-action">顧客總覽</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                        營主管理
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="campowner-list.php" class="list-group-item list-group-item-action">營主總覽</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->                                     <div class="accordion-item">
                                <h2 class="accordion-header" id="heading5">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                        營地管理
                                    </button>
                                </h2>
                                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="campcate-list.php" class="list-group-item list-group-item-action">營地分類列表</a>
                                            <a href="campcate-add.php" class="list-group-item list-group-item-action">營地分類創建</a>


                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->

                    <?php else: ?><?php endif; ?>
                    <div class="my-5"><a href="doLogout.php" class="btn btn-secondary">log out</a></div>


                </aside>


            </div><!-- col-4 -->
            <div class="col-lg-10">
                <div>
                    <div class="row">
                        <div class="py-2 d-flex justify-content-between">

                            <div>
                                共 <?= $campCount ?> 筆營地上架
                            </div>
                            <div>
                                <a role="button" class="btn btn-primary" href="camp-list.php">回列表</a>
                                <a class="btn btn-primary" href="camp-add.php">新增營地</a>
                            </div>
                        </div>
                        <div class="py-2 d-flex justify-content-center">
                            <div class="d-flex">
                                <h3>營地區域</h3>
                                <ul class="list-unstyled block d-flex">
                                    <?php foreach ($CampregionArr as $key => $value): ?>
                                        <li class="<?php if (isset($bigregion) && $key == $bigregion) echo "active" ?>"><a
                                                    href="camp-list.php?bigregion=<?= $key ?>"><?= $value ?></a></li>
                                    <?php endforeach; ?>

                                </ul>
                            </div>

                            <div class="d-flex">
                                <h3 >營地分類</h3>


                                <div class="dropdown me-3">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                       id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        北區
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                        <?php foreach ($Campcounty1Arr as $key => $value): ?>
                                            <li class="<?php if (isset($region) && $key == $region) echo "active" ?> ">
                                                <a class="dropdown-item"
                                                   href="camp-list.php?region=<?= $key ?>"><?= $value ?></a></li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>

                                <div class="dropdown me-3">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                       id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">中區
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <?php foreach ($Campcounty2Arr as $key => $value): ?>
                                            <li class="<?php if (isset($region) && $key == $region) echo "active" ?> ">
                                                <a class="dropdown-item"
                                                   href="camp-list.php?region=<?= $key ?>"><?= $value ?></a></li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>

                                <div class="dropdown me-3">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                       id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">南區
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <?php foreach ($Campcounty3Arr as $key => $value): ?>
                                            <li class="<?php if (isset($region) && $key == $region) echo "active" ?> ">
                                                <a class="dropdown-item"
                                                   href="camp-list.php?region=<?= $key ?>"><?= $value ?></a></li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>

                                <div class="dropdown me-3">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                       id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">東區
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <?php foreach ($Campcounty4Arr as $key => $value): ?>
                                            <li class="<?php if (isset($region) && $key == $region) echo "active" ?> ">
                                                <a class="dropdown-item"
                                                   href="camp-list.php?region=<?= $key ?>"><?= $value ?></a></li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>

                                <?php if ($campCount > 0): ?>
                                    <div class="py-2 d-flex justify-content-end price ">
                                        <div>

                                            <a class="<?php if (isset($order) && $order === "priceDesc") echo "active" ?>"
                                               href="camp-list.php?order=priceDesc">營地價格 ↓</a>
                                            <a class="<?php if (isset($order) && $order === "priceAsc") echo "active" ?>"
                                               href="camp-list.php?order=priceAsc">營地價格 ↑</a>
                                        </div>
                                    </div><!--block-->
                                <?php endif; ?>
                                <div class="mb-2">
                                    <label for="">搜尋</label>
                                    <form action="camp-list.php" method="get">
                                        <div class="d-flex align-items-center">
                                            <input type="search" class="form-control me-2" name="s"
                                                   value="<?php if (isset($search)) echo $search; ?>">
                                            <button type="submit" class="btn btn-primary text-nowrap">搜尋</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <main>
                            <table class="table table-bordered table-sm ">
                                <thead>
                                <tr>

                                    <th>營地名稱</th>
                                    <th>營地價格</th>
                                    <th>營地圖片</th>
                                    <th>類型</th>

                                    <th>營地位置</th>
                                    <th>營地須知</th>
                                    <th>營地介紹</th>
                                    <th>編輯</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($campCount > 0):
                                    while ($row = $result->fetch_assoc()): //關聯式陣列
                                        ?>
                                        <tr>

                                            <td><a class="link-success"
                                                   href="camp.php?id=<?= $row["campID"] ?>"><?= $row["campName"] ?>
                                                      </a>
                                            </td>
                                            <td>$<?= $row["campPrice"] ?></td>
                                            <td><img class="cover-fit" src="upload/<?= $row["campPic"] ?>"
                                                     alt="">
                                            </td>
                                            <td><?= $Campcate1Arr[$row["campCate1ID"]] ?><br><?= $Campcate3Arr[$row["campCate3ID"]] ?></td>

                                            <td><?= $CampcountyArr[$row["campCountyID"]],$CampdistArr[$row["campDistID"]],$row["campAdd"]  ?></td>
                                            <td><?= $row["campNote"] ?></td>
                                            <td><?= $row["campDes"] ?></td>
                                            <td>

                                                <a class="btn btn-primary mb-2"
                                                   href="camp-edit.php?id=<?= $row["campID"] ?>">修改</a>
                                                <a href="doDeletecamp.php?id=<?= $row["campID"] ?>"
                                                   class="btn btn-danger">刪除</a>
                                            </td>

                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9">沒有資料</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </main>
                    </div>

                </div>
            </div><!-- col-10 -->
        </div><!-- row -->

    </div><!-- container -->

</div><!-- mainsection -->


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>

<script>
    let changepicbox = document.querySelector("#changepicbox")
    let headbox = document.querySelector(".headbox")
    headbox.addEventListener("mouseover", function () {
        changepicbox.classList.remove("displayh");
    })
    headbox.addEventListener("mouseleave", function () {
        changepicbox.classList.add("displayh");
    })
    // --------------------------

</script>

</html>

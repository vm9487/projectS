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
if (isset($_GET["id"])) {
    $id = $_GET["id"];

} else {
    $id = 0;

}
require_once("../db-connect.php");
$sql = "SELECT * FROM camp_list JOIN campcate1 ON camp_list.campCate1ID=campcate1.campCate1ID WHERE campID='$id' ";
$result = $conn->query($sql);
$campExist = $result->num_rows;

$sql1 = "SELECT * FROM camp_list JOIN campcate3 ON camp_list.campCate3ID=campcate3.campCate3ID WHERE campID='$id' ";
$result1 = $conn->query($sql1);
$result1Exist = $result1->num_rows;

$sql2 = "SELECT * FROM camp_list JOIN camp_region ON camp_list.campRegionID=camp_region.campRegionID WHERE campID='$id' ";
$result2 = $conn->query($sql2);
$result2Exist = $result2->num_rows;

$sql3 = "SELECT * FROM camp_list JOIN camp_county ON camp_list.campCountyID=camp_county.campCountyID WHERE campID='$id' ";
$result3 = $conn->query($sql3);
$result3Exist = $result3->num_rows;

$sql4 = "SELECT * FROM camp_list JOIN camp_dist ON camp_list.campDistID=camp_dist.campDistID WHERE campID='$id' ";
$result4 = $conn->query($sql4);
$result4Exist = $result4->num_rows;

$sql5 = "SELECT * FROM camp_list WHERE campID='$id' ";
$result5 = $conn->query($sql5);
$result5Exist = $result5->num_rows;

$sqlcate1 = "SELECT * FROM campcate1";
$resultcate1 = $conn->query($sqlcate1);
$cate1 = $resultcate1->num_rows;


$sqlregion = "SELECT * FROM camp_region";
$resultregion = $conn->query($sqlregion);
$region = $resultregion->num_rows;


$sqlcounty = "SELECT * FROM camp_county ";
$resultcounty = $conn->query($sqlcounty);
$county = $resultcounty->num_rows;

$sqldist = "SELECT * FROM camp_dist ";
$resultdist = $conn->query($sqldist);
$dist = $resultdist->num_rows;

$sqlcate3 = "SELECT * FROM campcate3";
$resultcate3 = $conn->query($sqlcate3);
$cate3 = $resultcate3->num_rows;
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
        width: 400px;
        height: 200px;
        object-fit: cover;

    }

    .theImage {
        width: 300px;
        height: 200px;
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
                <div class="container">
                    <div class="py-2 d-flex justify-content-end">
                        <div>
                            <a class="btn btn-primary" href="camp-list.php">營地列表</a>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <?php if ($campExist === 0): ?>
                                此營地不存在
                            <?php else:
                            $row = $result->fetch_assoc();
                            $row1 = $result1->fetch_assoc();
                            $row2 = $result2->fetch_assoc();
                            $row3 = $result3->fetch_assoc();
                            $row4 = $result4->fetch_assoc();
                            $row5 = $result5->fetch_assoc();
                            ?>
                            <form action="doUpdatecamp.php" method="post" class="needs-validation"
                                  enctype="multipart/form-data" novalidate>

                                <div class="mb-3">
                                    <label for="CampID">CampID</label>
                                    <input id="id" type="text" name="id" class="form-control-plaintext"
                                           value="<?= $row["campID"] ?>"
                                           readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="campName">營地名稱</label>
                                    <input id="campName" type="text" name="campName" class="form-control"
                                           value="<?= $row["campName"] ?>" required>
                                    <div class="invalid-feedback">
                                        請輸入營地名稱
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="campPrice">營地價格</label>
                                    <input id="campPrice" type="text" name="campPrice" class="form-control"
                                           value="<?= $row["campPrice"] ?>" required>
                                    <div class="invalid-feedback">
                                        請輸入營地價格
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="formFileMultiple" class="form-label">營地圖片</label>
                                    <input class="form-control form-control-sm" type="file" name="myFile"
                                           id="theImgFile" multiple onchange="onLoadImgFile()">
                                    <img class="cover-fit theImage" src="upload/<?= $row["campPic"] ?>" alt="">


                                </div>
                                <div class="form-floating mb-3">

                    <textarea class="form-control" name="campNote" id="" placeholder="Leave a comment here"
                              id="floatingTextarea2" style="height: 100px" required><?= $row["campNote"] ?></textarea>
                                    <div class="invalid-feedback">
                                        請輸入文字
                                    </div>
                                    <label for="floatingTextarea2">營地須知</label>

                                </div>


                                <div class="form-floating mb-3">

                    <textarea class="form-control" name="campDes" id="" placeholder="Leave a comment here"
                              id="floatingTextarea2" style="height: 100px" required><?= $row["campDes"] ?></textarea>
                                    <div class="invalid-feedback">
                                        請輸入文字
                                    </div>
                                    <label for="floatingTextarea2">營地介紹</label>

                                </div>
                                <div class="mb-3">
                                    <label for="campCate1ID">露營類型</label>
                                    <select class="form-control" name="campCate1ID" id="campCate1ID" required>

                                        <option value="<?= $row["campCate1ID"] ?>"><?= $row["campCate1item"] ?></option>
                                        <?php while ($row = $resultcate1->fetch_assoc()): ?>
                                            <option value="<?= $row["campCate1ID"] ?>"><?= $row["campCate1item"] ?></option>
                                        <?php endwhile; ?>

                                    </select>
                                    <div class="invalid-feedback">
                                        請選擇露營類型
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="campCate3ID">露營主題</label>
                                    <select class="form-control" name="campCate3ID" id="campCate3ID" required>
                                        <option value="<?= $row1["campCate3ID"] ?>"><?= $row1["campCate3item"] ?></option>
                                        <?php while ($row = $resultcate3->fetch_assoc()): ?>
                                            <option value="<?= $row["campCate3ID"] ?>"><?= $row["campCate3item"] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        請選擇露營主題
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="campRegion">營地區域</label>
                                    <select class="form-control" name="campRegionID" id="campRegionID" required>
                                        <option value="<?= $row2["campRegionID"] ?>"><?= $row2["campRegion"] ?></option>
                                        <?php while ($row = $resultregion->fetch_assoc()): ?>
                                            <option value="<?= $row["campRegionID"] ?>"><?= $row["campRegion"] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        請選擇露營區域
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="campCate2ID">營地市區</label>

                                    <select class="form-control" name="campCountyID" id="campCountyID" required>
                                        <option value="<?= $row3["campCountyID"] ?>"><?= $row3["campCounty"] ?></option>
                                        <?php while ($row = $resultcounty->fetch_assoc()): ?>
                                            <option value="<?= $row["campCountyID"] ?>"><?= $row["campCounty"] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        請選擇露營市區
                                    </div>


                                </div>
                                <div class="mb-3">
                                    <label for="campDist">營地縣市</label>
                                    <select class="form-control" name="campDistID" id="campDistID" required>
                                        <!-- <option value="<?= $row4["campDistID"] ?>"><?= $row4["campDist"] ?></option>
                                        <option value="-------" disabled="disabled">-----------------</option> -->
                                        <?php while ($row = $resultdist->fetch_assoc()): ?>
                                            <option value="<?= $row["campDistID"] ?> " 

                                            <?php if ($row["campDistID"]==$row4["campDistID"])
                                            {echo "selected";}; ?>
                                            >
                                            <?= $row["campDist"] ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        請選擇露營縣市
                                    </div>


                                </div>
                                <div class="mb-3">
                                    <label for="campAdd">營地地址</label>
                                    <input class="form-control form-control-sm" type="text" name="campAdd" value="<?= $row5["campAdd"] ?>" required>
                                    <div class="invalid-feedback">
                                        請輸入地址
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">修改</button>
                                <a href="camp-list.php" class="btn btn-primary">返回</a>

                        </div>
                    </div>

                </div>
            </div>
            </form>
            <?php endif; ?>

        </div>
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
    (function () {
        'use strict'


        var forms = document.querySelectorAll('.needs-validation')


        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()

                    }
                    form.classList.add('was-validated');
                    //  alert("修改完成");location.href="camp-list.php";


                }, false)
            })
    })()

    function onLoadImgFile() {
        var theFileElem = document.getElementById("theImgFile");

        if (theFileElem.files.length != 0 && theFileElem.files[0].type.match(/image.*/)) {

            var reader = new FileReader();
            reader.onload = function (e) {
                var theImgElem = document.querySelector(".theImage");

                theImgElem.src = this.result //this為FIleReader

            };
            reader.onerror = function (e) {
                alert("Cannot load img file");
            };

            reader.readAsDataURL(theFileElem.files[0]);
        } else {
            alert("Please select a img file");
        }
    }



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

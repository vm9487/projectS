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

//////////////////////////////////////////////////////////////////////

if(isset($_GET["campOwnerID"])){
    $campOwnerID=$_GET["campOwnerID"];
}else{
    $campOwnerID=0;
}
require_once ("../db-connect.php");
$sql="SELECT * FROM camp_owner_list WHERE campOwnerID='$campOwnerID' AND campOwnerValid=1";
$result=$conn->query($sql);
$campOwnerExist=$result->num_rows;


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
      <link rel="stylesheet" href="headpicimage.css">
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
            <div class="d-flex justify-content-center">
        <h2>營主管理</h2>
    </div>
<div class="container">
    <div class="py-2 d-flex justify-content-end">
        <div>
            <a class="btn btn-primary" href="campowner-list.php">營主列表</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if($campOwnerExist===0): ?>
                    營主不存在
                <?php else: 
                     $row=$result->fetch_assoc();
                    ?>
            <form action="doUpdate.php" method="post">
                <input type="hidden" name="campOwnerID" value="<?=$row["campOwnerID"]?>">
                <div class="mb-3">
                    <label for="account">帳號</label>
                    <input id="account" type="text" name="campOwnerAccount" class="form-control-plaintext" value="<?=$row["campOwnerAccount"]?>" readonly>
                </div>
                <!-- <div class="mb-3">
                    <label for="password">密碼</label>
                    <input id="password" type="text" name="customerPassword" class="form-control" >
                </div> -->
                <div class="mb-3">
                    <label for="name">姓名</label>
                    <input id="name" type="text" name="campOwnerName" class="form-control" value="<?=$row["campOwnerName"]?>">
                </div>
                <div class="mb-3">
                    <label for="gender">性別</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="campOwnerGender" id="" value="<?=$row["campOwnerGender"]?>">
                            <label class="form-check-label" for="inlineRadio1">male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="campOwnerGender" id="" value="<?=$row["campOwnerGender"]?>">
                            <label class="form-check-label" for="inlineRadio1">female</label>
                        </div>
                </div>
                <div class="mb-3">
                <label for="birthday">出生日期</label>
                    <input id="Birthday" type="date" name="campOwnerBday" class="form-control" value="<?=$row["campOwnerBday"]?>">                                                        
                </div>
                <div class="mb-3">
                    <label for="phone">電話</label>
                    <input id="phone" type="text" name="campOwnerPhone" class="form-control" value="<?=$row["campOwnerPhone"]?>">
                </div>
                <div class="mb-3">
                    <label for="company">公司名稱</label>
                    <input id="phone" type="text" name="campOwnerCompanyName" class="form-control" value="<?=$row["campOwnerCompanyName"]?>">
                </div>
                <div class="mb-3">
                <label for="picture">照片</label>
                        <div class="figure ">  
                            <img class="img-fluid cover-fit" src="images/<?=$row["campOwnerPic"]?>" alt="">
                        </div>                                                     
                </div>
                <button class="btn btn-primary" type="submit">送出</button>
                <a href="doDelete.php?campOwnerID=<?=$row["campOwnerID"]?>" class="btn btn-danger">刪除</a>
            </form>
            <?php endif; ?>               
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




<!-- ------------------------------------------------- -->

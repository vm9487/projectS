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
    // ----------------------訂單sql------------------------------------------------
if (isset($_GET["status"])){
    $status=$_GET["status"];
    var_dump($status);
    $sql="SELECT order_detail.*, customer_list.*, order_status.*, camp_list.*
    FROM (
             (order_detail JOIN customer_list 
            ON order_detail.customerID = customer_list.customerID
            )
        JOIN order_status
        ON order_detail.orderStatusID=order_status.orderStatusID
        )
    JOIN camp_list
    ON order_detail.campID=camp_list.campID
    WHERE order_detail.orderStatusID= ? AND order_detail.customerID= ?
    ORDER BY createdTime
    ";
    $stmt=$db_host->prepare($sql);
    try {
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowCount=$stmt->rowCount();
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}else{
    // var_dump($status);
    // echo" here";
    $sql="SELECT order_detail.*, customer_list.*, order_status.*, camp_list.*
    FROM (
             (order_detail JOIN customer_list 
            ON order_detail.customerID = customer_list.customerID
            )
        JOIN order_status
        ON order_detail.orderStatusID=order_status.orderStatusID
        )
    JOIN camp_list
    ON order_detail.campID=camp_list.campID
    WHERE order_detail.customerID= ?
    ORDER BY createdTime
    ";
    $stmt=$db_host->prepare($sql);
    try {
        $stmt->execute([$id]);
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowCount=$stmt->rowCount();
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}


// ------------------訂單sql----end------------------------------------------------------

} elseif (isset($_SESSION["usercamp"])) {
//    echo"usercamp";

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
            <main class="p-4">
                    <h2>訂單列表</h2>
                    <div class="mb-2 status">
                        <a class="me-2 <?php if(!isset($status)) echo "active" ?>" href="customer_order.php" >總訂單</a>
                        <a class="me-2 <?php if(isset($status) && $status==1) echo "active" ?>" href="customer_order.php?status=1">未結帳訂單</a>
                        <a class="me-2 <?php if(isset($status) && $status==2) echo "active" ?>" href="customer_order.php?status=2">已結帳訂單</a>
                        <a class="me-2 <?php if(isset($status) && $status==3) echo "active" ?>" href="customer_order.php?status=3">已取消訂單</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>營地名稱</th>
                                <th>預定人姓名</th>
                                <th>預定人電話</th>
                                <th>人數</th>
                                <th>入住日</th>
                                <th>退房日</th>
                                <th>價格</th>
                                <th>下訂時間</th>
                                <th>訂單狀態</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($rowCount>0):
                            foreach ($row as $value):
                                if ($value["orderStatusID"]==1):
                                    // echo $value["orderStatusItem"];
                                ?>
                                <form action="doCancelOrder.php" method="post">
                                    <tr>
                                        <td><?=$value["campName"]?></td>
                                        <td><?=$value["customerName"]?></td>
                                        <td><?=$value["customerPhone"]?></td>
                                        <td><?=$value["numPpl"]?></td>
                                        <td><?=$value["orderDateStart"]?></td>
                                        <td><?=$value["orderDateEnd"]?></td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <?php
                                                //列出所有日期
                                                $start_time = strtotime($value["orderDateStart"]);
                                                $end_time = strtotime($value["orderDateEnd"]);
                                                $i=0;
                                                $arr=[];
                                                while ($start_time<=$end_time){
                                                    $arr[$i]=date('Y-m-d',$start_time);
                                                    $start_time = strtotime('+1 day',$start_time);
                                                    $i++;
                                                }

                                                //取得共有幾天
                                                $dayCount=count($arr);

                                                //列出是星期幾(1~5平日 / 6、0假日)
                                                $week=[];
                                                for ($i=0; $i<$dayCount; $i++){
                                                    $week[]=date("w",strtotime("$arr[$i]"));
                                                }

                                                //判斷價錢
                                                $holiday=500; //假日多加的錢
                                                $holidayPrice=[];
                                                $weekdayPrice=[];
                                                for ($j=0; $j<$dayCount; $j++){
                                                    if($week[$j]==6){
                                                        $holidayPrice[]=(int)$value["campPrice"]+$holiday;
                                                    }else if($week[$j]==0){
                                                        $holidayPrice[]=(int)$value["campPrice"]+$holiday;
                                                    }else{
                                                        $weekdayPrice[]=(int)$value["campPrice"];
                                                    }
                                                }
                                                echo array_sum($holidayPrice)+array_sum($weekdayPrice);
                                                ?>
                                            </div>
                                        </td>
                                        <td><?=$value["createdTime"]?></td>
                                        <td><?=$value["orderStatusItem"]?></td>
                                        <td>
                                            <input type="hidden" name="orderID" value="<?=$value["orderID"]?>">
                                            <button type="submit" class="btn btn-outline-danger" >取消訂單</button>
                                        </td>
                                    </tr>
                                </form>
                                <?php
                                elseif($value["orderStatusID"]==2):
                                ?>
                                    <tr class="table-dark">
                                        <td><?=$value["campName"]?></td>
                                        <td><?=$value["customerName"]?></td>
                                        <td><?=$value["customerPhone"]?></td>
                                        <td><?=$value["numPpl"]?></td>
                                        <td><?=$value["orderDateStart"]?></td>
                                        <td><?=$value["orderDateEnd"]?></td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <?php
                                                //列出所有日期
                                                $start_time = strtotime($value["orderDateStart"]);
                                                $end_time = strtotime($value["orderDateEnd"]);
                                                $i=0;
                                                $arr=[];
                                                while ($start_time<=$end_time){
                                                    $arr[$i]=date('Y-m-d',$start_time);
                                                    $start_time = strtotime('+1 day',$start_time);
                                                    $i++;
                                                }

                                                //取得共有幾天
                                                $dayCount=count($arr);

                                                //列出是星期幾(1~5平日 / 6、0假日)
                                                $week=[];
                                                for ($i=0; $i<$dayCount; $i++){
                                                    $week[]=date("w",strtotime("$arr[$i]"));
                                                }

                                                //判斷價錢
                                                $holiday=500; //假日多加的錢
                                                $holidayPrice=[];
                                                $weekdayPrice=[];
                                                for ($j=0; $j<$dayCount; $j++){
                                                    if($week[$j]==6){
                                                        $holidayPrice[]=(int)$value["campPrice"]+$holiday;
                                                    }else if($week[$j]==0){
                                                        $holidayPrice[]=(int)$value["campPrice"]+$holiday;
                                                    }else{
                                                        $weekdayPrice[]=(int)$value["campPrice"];
                                                    }
                                                }
                                                echo array_sum($holidayPrice)+array_sum($weekdayPrice);
                                                ?>
                                            </div>
                                        </td>
                                        <td><?=$value["createdTime"]?></td>
                                        <td><?=$value["orderStatusItem"]?></td>
                                        <td></td>
                                    </tr>
                                <?php  else:  ?>
                                    <form action="doRecoverOrder.php" method="post">
                                        <tr class="table-secondary">
                                            <td><?=$value["campName"]?></td>
                                            <td><?=$value["customerName"]?></td>
                                            <td><?=$value["customerPhone"]?></td>
                                            <td><?=$value["numPpl"]?></td>
                                            <td><?=$value["orderDateStart"]?></td>
                                            <td><?=$value["orderDateEnd"]?></td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <?php
                                                    //列出所有日期
                                                    $start_time = strtotime($value["orderDateStart"]);
                                                    $end_time = strtotime($value["orderDateEnd"]);
                                                    $i=0;
                                                    $arr=[];
                                                    while ($start_time<=$end_time){
                                                        $arr[$i]=date('Y-m-d',$start_time);
                                                        $start_time = strtotime('+1 day',$start_time);
                                                        $i++;
                                                    }

                                                    //取得共有幾天
                                                    $dayCount=count($arr);

                                                    //列出是星期幾(1~5平日 / 6、0假日)
                                                    $week=[];
                                                    for ($i=0; $i<$dayCount; $i++){
                                                        $week[]=date("w",strtotime("$arr[$i]"));
                                                    }

                                                    //判斷價錢
                                                    $holiday=500; //假日多加的錢
                                                    $holidayPrice=[];
                                                    $weekdayPrice=[];
                                                    for ($j=0; $j<$dayCount; $j++){
                                                        if($week[$j]==6){
                                                            $holidayPrice[]=(int)$value["campPrice"]+$holiday;
                                                        }else if($week[$j]==0){
                                                            $holidayPrice[]=(int)$value["campPrice"]+$holiday;
                                                        }else{
                                                            $weekdayPrice[]=(int)$value["campPrice"];
                                                        }
                                                    }
                                                    echo array_sum($holidayPrice)+array_sum($weekdayPrice);
                                                    ?>
                                                </div>
                                            </td>
                                            <td><?=$value["createdTime"]?></td>
                                            <td><?=$value["orderStatusItem"]?></td>
                                            <td>
                                                <input type="hidden" name="orderID" value="<?=$value["orderID"]?>">
                                                <button type="submit" class="btn btn-outline-secondary">復原</button>
                                            </td>
                                        </tr>
                                    </form>
                            <?php endif;
                            endforeach;
                            else:?>
                                <tr>
                                    <td colspan="9">沒有資料</td>
                                </tr>
                            <?php
                            endif;
                            ?>
                        </tbody>
                    </table>
                </main>
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
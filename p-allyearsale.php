<?php
require_once("../db-PDOconnect4project.php");
if ((isset($_SESSION["user"])) or (isset($_SESSION["usercamp"]))
    ) {
} else {
    header("location: p-login.php");
}

///////////////////////////////////////////////////////////////////////
if (isset($_SESSION["user"])) {

} elseif (isset($_SESSION["usercamp"])) {
//    echo"usercamp";
//----------------------------------------------------------------------
    $id = $_SESSION["usercamp"]["campOwnerID"];
    $usercamp=$_SESSION["usercamp"];
    $campOwnerID=$usercamp["campOwnerID"];
    $sqlprofile = "SELECT * FROM camp_owner_list WHERE campOwnerID=? AND campOwnerValid=1 ";
    $stmtprofile = $db_host->prepare($sqlprofile);
    try {
        $stmtprofile->execute([$id]);
        $rowprofile = $stmtprofile->rowCount();
        $rowprofile2 = $stmtprofile->fetchAll(PDO::FETCH_ASSOC);
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

 ////////////////////////////////////////////////////////////////////   
    $sqlallyearsale = "SELECT order_detail.*, camp_list.* 
    FROM order_detail JOIN camp_list ON order_detail.campID=camp_list.campID
    WHERE camp_list.campOwnerID=? AND orderStatusID=1";
        $stmtallyearsale = $db_host->prepare($sqlallyearsale);
        try {
            $stmtallyearsale->execute([$id]);
            $rowallyearsale = $stmtallyearsale->rowCount();
            $rowallyearsale = $stmtallyearsale->fetchAll(PDO::FETCH_ASSOC);

            // foreach($rowallyearsale as $row){
            //                foreach($row as $key => $value){
            //                    print_r( $row["orderDateStart"]);
            //                    echo $key." : ".$value."<br />";}}
    
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
/////////////////////////////////////////////////////////////////////////////////////////
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
WHERE campOwnerID=$campOwnerID
ORDER BY createdTime
";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute();
    $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $rowCount=$stmt->rowCount();
}catch (PDOException $e){
    echo $e->getMessage();
}




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
    <title>All Year Sales</title>
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
    .paint{
        width: 70vw;
        

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

                    <a href="product_list.php">???????????????</a>
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
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        ????????????
                                    </button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="p-profile.php" class="list-group-item list-group-item-action">??????????????????</a>
                                            <a href="#" class="list-group-item list-group-item-action">????????????</a>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingone">
                                    <a href="p-dashboard2.php" class=" block py-2 my-2 accordion-button collapsed" type="button" ">
                                        ????????????
                                    </a>
                                </h2>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <a href="customer_order.php" class=" block py-2 my-2 accordion-button collapsed" type="button" ">
                                        ????????????
                                    </a>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="#" class="list-group-item list-group-item-action">????????????</a>
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
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                        ????????????
                                    </button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="p-profile.php" class="list-group-item list-group-item-action">??????????????????</a>
                                            <a href="#" class="list-group-item list-group-item-action">????????????</a>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingone">
                                    <a href="p-dashboard2.php" class=" block py-2 my-2 accordion-button collapsed" type="button" >
                                        ????????????
                                    </a>
                                </h2>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        ????????????
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="owner_order_management.php" class="list-group-item list-group-item-action">????????????</a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                        ????????????
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="p-biz.php" class="list-group-item list-group-item-action">????????????</a>
                                            <a href="p-monthlybiz.php" class="list-group-item list-group-item-action">??????????????????</a>
                                            <a href="p-futurebiz.php" class="list-group-item list-group-item-action">??????????????????</a>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->                                     <div class="accordion-item">
                                <h2 class="accordion-header" id="heading5">
                                    <button class=" block py-2 my-2 accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                        ????????????
                                    </button>
                                </h2>
                                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <a href="camp-list.php" class="list-group-item list-group-item-action">????????????</a>
                                            <a href="camp-add.php" class="list-group-item list-group-item-action">????????????</a>



                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd-->

                    <?php elseif (isset($_SESSION["usersuper"])): ?>

                    <?php else: ?>

                    <?php endif; ?>

                    <div class="my-5"><a href="doLogout.php" class="btn btn-secondary ">log out</a></div>
                </aside>


            </div><!-- col-2 -->
            <div class="col-lg-10"> 
                
                <div class="d-flex justify-content-center my-3 border-bottom">
                 <h2>All Year Sales</h2>
                </div>
                <main class=" d-flex flex-column justify-content-center">
                    <div class="paint"><canvas id="myChart"></canvas></div>
                    
                    <div class="mb-2 status">
                        <a class="me-2 <?php if(!isset($status)) echo "active" ?>" href="owner_order_management.php" >?????????</a>
                        <a class="me-2 <?php if(isset($status) && $status==1) echo "active" ?>" href="owner_order_management.php?status=1">???????????????</a>
                        <a class="me-2 <?php if(isset($status) && $status==2) echo "active" ?>" href="owner_order_management.php?status=2">???????????????</a>
                        <a class="me-2 <?php if(isset($status) && $status==3) echo "active" ?>" href="owner_order_management.php?status=3">???????????????</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>????????????</th>
                                <th>???????????????</th>
                                <th>???????????????</th>
                                <th>??????</th>
                                <th>?????????</th>
                                <th>?????????</th>
                                <th>??????</th>
                                <th>????????????</th>
                                <th>????????????</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($rowCount>0):
                            foreach ($row as $value):
                                if ($value["orderStatusID"]==1):
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
                                                //??????????????????
                                                $start_time = strtotime($value["orderDateStart"]);
                                                $end_time = strtotime($value["orderDateEnd"]);
                                                $i=0;
                                                $arr=[];
                                                while ($start_time<=$end_time){
                                                    $arr[$i]=date('Y-m-d',$start_time);
                                                    $start_time = strtotime('+1 day',$start_time);
                                                    $i++;
                                                }

                                                //??????????????????
                                                $dayCount=count($arr);

                                                //??????????????????(1~5?????? / 6???0??????)
                                                $week=[];
                                                for ($i=0; $i<$dayCount; $i++){
                                                    $week[]=date("w",strtotime("$arr[$i]"));
                                                }

                                                //????????????
                                                $holiday=500; //??????????????????
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
                                            <button type="submit" class="btn btn-outline-danger">????????????</button>
                                        </td>
                                    </tr>
                                </form>
                                <?php
                                elseif($value["orderStatusID"]==2):
                                ?>
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
                                                //??????????????????
                                                $start_time = strtotime($value["orderDateStart"]);
                                                $end_time = strtotime($value["orderDateEnd"]);
                                                $i=0;
                                                $arr=[];
                                                while ($start_time<=$end_time){
                                                    $arr[$i]=date('Y-m-d',$start_time);
                                                    $start_time = strtotime('+1 day',$start_time);
                                                    $i++;
                                                }

                                                //??????????????????
                                                $dayCount=count($arr);

                                                //??????????????????(1~5?????? / 6???0??????)
                                                $week=[];
                                                for ($i=0; $i<$dayCount; $i++){
                                                    $week[]=date("w",strtotime("$arr[$i]"));
                                                }

                                                //????????????
                                                $holiday=500; //??????????????????
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
                                <?php
                                else:
                                ?>
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
                                                    //??????????????????
                                                    $start_time = strtotime($value["orderDateStart"]);
                                                    $end_time = strtotime($value["orderDateEnd"]);
                                                    $i=0;
                                                    $arr=[];
                                                    while ($start_time<=$end_time){
                                                        $arr[$i]=date('Y-m-d',$start_time);
                                                        $start_time = strtotime('+1 day',$start_time);
                                                        $i++;
                                                    }

                                                    //??????????????????
                                                    $dayCount=count($arr);

                                                    //??????????????????(1~5?????? / 6???0??????)
                                                    $week=[];
                                                    for ($i=0; $i<$dayCount; $i++){
                                                        $week[]=date("w",strtotime("$arr[$i]"));
                                                    }

                                                    //????????????
                                                    $holiday=500; //??????????????????
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
                                                <button type="submit" class="btn btn-outline-secondary">??????</button>
                                            </td>
                                        </tr>
                                    </form>
                            <?php
                                endif;
                            endforeach;
                            else:
                            ?>
                                <tr>
                                    <td colspan="9">????????????</td>
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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<!-- ---------------------------- -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
<!-- ---------------------------- -->
</body>

<!-- type ????????????????????????????????????????????????????????? pie ?????????????????? labels ????????????????????????????????????????????????????????? data.datasets.data ?????????

?????????????????????????????? backgroundColor ??? borderColor???????????? borderWidth ???????????????????????????????????????????????? -->

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            label: '????????????',
            data: 
            [
            152, 
            23319,
            3,
            5,
            2, 
            2, 
            2, 
            2, 
            2, 
            2, 
            2,   
            3
               ],
            backgroundColor: [
                'rgba(17, 112, 107, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(17, 112, 107, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(17, 112, 107, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(17, 112, 107, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(17, 112, 107, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(17, 112, 107, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                
            ],
            borderColor: [
                'rgba(17, 112, 107, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(17, 112, 107, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(17, 112, 107, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(17, 112, 107, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(17, 112, 107, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(17, 112, 107, 1)',
                'rgba(75, 192, 192, 1)',
                
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


</script>

</html>
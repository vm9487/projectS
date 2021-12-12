<?php
// require_once ("../pdo_connect.php");
require_once("../db-PDOconnect4project.php");

//☆☆☆面板☆☆☆
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

if (isset($_GET["campID"])){
    $campID=$_GET["campID"];
}else{
    $campID=0;
}

$sql="SELECT * FROM camp_list WHERE campValid=1 AND campID=$campID";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute();
    $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $rowCount=$stmt->rowCount();
}catch (PDOException $e){
    echo $e->getMessage();
}
//var_dump($row);
?>
<!doctype html>
<html lang="en">

<head>
    <title>營地介紹</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/header&aside_UI.php"> -->
    <link rel="stylesheet" href="css/product-intro.css">
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css">

<!--    日期、放在header裡-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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

/*模組*/
.cover-fit{
    height: 100%;
    width: 100%;
    object-fit: cover;
}
/*a {*/
/*    text-decoration: none;*/
/*    color: #000;*/
/*}*/

/*日期選擇*/
.datePicker {
    width: 200px;
}
</style>

</head>

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
                    <a class="me-3" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
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
    <div class="container">
        <main>
            <?php
            if ($rowCount>0):
            foreach ($row as $value):
            ?>
                <div class="row mt-5">
                    <figure>
                        <img  class="cover-fit" src="<?=$value["campPic"]?>" alt="">
                    </figure>
                    <h1 class="mt-4 text-center"><?=$value["campName"]?></h1>
                    <h6>02-2636-6757</h6>
                    <h6><?=$value["campAdd"]?></h6>
                    <div class="mt-4">
                        <p><?=$value["campDes"]?></p>
                    </div>
                    <div class="mt-4">
                        <h4>營地須知</h4>
                    </div>
                    <div class="mt-4">
                        <h4>價格</h4>
                        平日 <?=$value["campPrice"]?><br>
                        假日 <?=$value["campPrice"]+500?>
                    </div>
                    <div class="mt-4">
                        <h4>空位預約</h4>
                        <form action="doAddToCart.php" method="post">
                            <?php
                            $tomorrow = date('Y/m/d',strtotime("+1 day"));
                            $nextMonth = date('Y/m/d',strtotime("+1 month"));
                            ?>
                            <div class="row">
<!--                                <div class="col-auto">-->
<!--                                    <input type="date" name="startDate" class="form-control" min="--><?//=$tomorrow?><!--" max="--><?//=$nextMonth?><!--">-->
<!--                                </div>-->
<!--                                <div class="col-auto">~</div>-->
<!--                                <div class="col-auto">-->
<!--                                    <input type="date" name="endDate" class="form-control" min="--><?//=$tomorrow?><!--" max="--><?//=$nextMonth?><!--">-->
<!--                                </div>-->
<!--                                日期-->
                                <div>
                                    <input type="text" name="daterange" value="<?=$tomorrow?> - <?=$nextMonth?>" class="datePicker">
                                </div>
<!--                                end-->
                                <div class="mt-4">
                                    人數
                                    <input type="number" name="ppl" min="1" max="10" required>
                                </div>
                                <div class="mt-4">
                                    <button role="button" type="submit" class="btn btn-primary text-white mb-5">預約</button>
                                </div>
                            </div>
                            <input type="hidden" name="campID" value="<?=$campID?>">
                            <input type="hidden" name="campName" value="<?=$value["campName"]?>">
                        </form>
                    </div>

                 </div>
            <?php
            endforeach;
            endif;
            ?>


        </main>
    </div><!-- container -->
</div><!-- mainsection -->
</body>
</html>

<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'right',
            autoApply: true,
            locale: {
                format: 'YYYY/MM/DD'
            }
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>
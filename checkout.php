<?php
require_once ("../pdo_connect.php");

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

if (isset($_SESSION["user"])){

}else{
    header("location: pleas_login_first.php");
    exit();
}

$cart=$_SESSION["cartArr"];

$sql="SELECT * FROM camp_list WHERE campValid=1";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute();
    $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $rowCount=$stmt->rowCount();
}catch (PDOException $e){
    echo $e->getMessage();
}

$user=$_SESSION["user"];
$customerID=$user["customerID"];

$sqlCustomer="SELECT customerName, customerPhone FROM customer_list WHERE customerID=?";
$stmtCustomer=$db_host->prepare($sqlCustomer);
try {
    $stmtCustomer->execute([$customerID]); //注意！這裡的值要改成現在登入人的customerID
    $rowCustomer=$stmtCustomer->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e){
    echo $e->getMessage();
}
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
    <link rel="stylesheet" href="css/header&aside_UI.php">
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css">

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
        <h4 class="mt-4">訂購人資訊</h4>
        <table class="table table-bordered">
            <thead>
                
            </thead>
            <tbody>
                <tr>
                    <td class="col-1">姓名</td>
                    <td><?=$rowCustomer[0]["customerName"]?></td>
                </tr>
                <tr>
                    <td>手機</td>
                    <td><?=$rowCustomer[0]["customerPhone"]?></td>
                </tr>
            </tbody>
        </table>
        <h4 class="mt-4">訂位資訊</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>營地名稱</td>
                    <td>人數</td>
                    <td>入住日</td>
                    <td>退房日</td>
                    <td>價格</td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($cart as $value):
            ?>
                    <tr>
                        <td><?=$value["campName"]?></td>
                        <td><?=$value["ppl"]?></td>
                        <td>
                            <?php
                            $value["startDate"] = strtotime($value["startDate"]);
                            $value["startDate"] = date("Y-m-d", $value["startDate"] );
                            echo $value["startDate"];
                            ?>
                        </td>
                        <td>
                            <?php
                            $value["endDate"] = strtotime($value["endDate"]);
                            $value["endDate"] = date("Y-m-d", $value["endDate"] );
                            echo $value["endDate"];
                            ?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <?php
                                //列出所有日期
                                $start_time = strtotime($value["startDate"]);
                                $end_time = strtotime($value["endDate"]);
                                $i=0;
                                $arr=[];
                                while ($start_time<=$end_time){
                                    $arr[$i]=date('Y-m-d',$start_time);
                                    $start_time = strtotime('+1 day',$start_time);
                                    $i++;
                                }
                                //                            var_dump($arr);

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
                                $campID=$value["campID"]-1;
                                for ($j=0; $j<$dayCount; $j++){
                                    if($week[$j]==6){
                                        $holidayPrice[]=(int)$row[$campID]["campPrice"]+$holiday;
                                    }else if($week[$j]==0){
                                        $holidayPrice[]=(int)$row[$campID]["campPrice"]+$holiday;
                                    }else{
                                        $weekdayPrice[]=(int)$row[$campID]["campPrice"];
                                    }
                                }
                                //                                echo array_sum($holidayPrice)+array_sum($weekdayPrice);
                                $price=array_sum($holidayPrice)+array_sum($weekdayPrice);
                                echo $price;

                                //加總

                                if (!isset($total)){
                                    $total=[$price];
                                }else{
                                    array_push($total, $price);
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
                <tr>
                    <td colspan="5">
                        <div class="d-flex justify-content-end">
                            總價
                            <?php
                            echo array_sum($total);
                            ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-4">
            <a class="btn btn-primary" href="doCheckout.php">確認結帳</a>
        </div>
    </div><!-- container -->

</div><!-- mainsection -->
</body>
</html>

<?php
require_once("../camp/pdo_connect.php");

//篩選訂單狀態
//注意！兩個WHERE都要改成登入人的campOwnerID！！！！！
if (isset($_GET["status"])){
    $status=$_GET["status"];
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
    WHERE order_detail.orderStatusID=$status AND campOwnerID=1
    ORDER BY createdTime
    ";
}else{
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
    WHERE campOwnerID=1
    ORDER BY createdTime
    ";
}
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute();
    $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $rowCount=$stmt->rowCount();
}catch (PDOException $e){
    echo $e->getMessage();
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>營主訂單</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/owner_order_management.css">

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
                    <a href="">username</a>
                    <img class="coverfit headpic mx-2" src="./img/pepe.png" alt="pepethefrog">
                    <a href="">回網站首頁</a>
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
                    <div class="block py-2 my-2">管理首頁</div>
                    <div class="block py-2 my-2">營地訂單</div>
                    <div class="block py-2 my-2">業績檢視</div>
                    <div class="block py-2 my-2">營地管理</div>
                    <div class="block py-2 my-2">活動列表</div>
                </aside>
            </div><!-- col-4 -->
            <div class="col-lg-10">
                <main class="p-4">
                    <h2>訂單列表</h2>
                    <div class="mb-2 status">
                        <a class="me-2 <?php if(!isset($status)) echo "active" ?>" href="owner_order_management.php" >總訂單</a>
                        <a class="me-2 <?php if(isset($status) && $status==1) echo "active" ?>" href="owner_order_management.php?status=1">未結帳訂單</a>
                        <a class="me-2 <?php if(isset($status) && $status==2) echo "active" ?>" href="owner_order_management.php?status=2">已結帳訂單</a>
                        <a class="me-2 <?php if(isset($status) && $status==3) echo "active" ?>" href="owner_order_management.php?status=3">已取消訂單</a>
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
                                if ($value["orderStatusID"]!=3):
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
                                        <td><?=$value["orderStatus"]?></td>
                                        <td>
                                            <input type="hidden" name="orderID" value="<?=$value["orderID"]?>">
                                            <button type="submit" class="btn btn-outline-danger">取消訂單</button>
                                        </td>
                                    </tr>
                                </form>
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
                                            <td><?=$value["orderStatus"]?></td>
                                            <td>
                                                <input type="hidden" name="orderID" value="<?=$value["orderID"]?>">
                                                <button type="submit" class="btn btn-outline-secondary">復原</button>
                                            </td>
                                        </tr>
                                    </form>
                            <?php
                                endif;
                            endforeach;
                            else:
                            ?>
                                <tr>
                                    <td colspan="9">沒有資料</td>
                                </tr>
                            <?php
                            endif;
                            ?>
                        </tbody>
                    </table>
                </main>
            </div><!-- col-8 -->
        </div><!-- row -->

    </div><!-- container -->

</div><!-- mainsection -->
</body>
</html>

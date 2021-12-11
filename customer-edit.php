<?php
if(isset($_GET["customerID"])){
    $customerID=$_GET["customerID"];
}else{
    $customerID=0;
}
require_once ("../db-connect.php");
$sql="SELECT * FROM customer_list WHERE customerID='$customerID' AND customerValid=1";
$result=$conn->query($sql);
$customerExist=$result->num_rows;
?>
<!doctype html>
<html lang="en">
<head>
    <title>customer-edit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="headpicimage.css">
</head>
<body>
    <div class="d-flex justify-content-center">
        <h2>消費者管理</h2>
    </div>
<div class="container">
    <div class="py-2 d-flex justify-content-end">
        <div>
            <a class="btn btn-primary" href="customer-list.php">消費者列表</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if($customerExist===0): ?>
                    消費者不存在
                <?php else: 
                     $row=$result->fetch_assoc();
                    ?>
            <form action="doUpdate.php" method="post">
                <input type="hidden" name="customerID" value="<?=$row["customerID"]?>">
                <div class="mb-3">
                    <label for="account">帳號</label>
                    <input id="account" type="text" name="customerAccount" class="form-control-plaintext" value="<?=$row["customerAccount"]?>" readonly>
                </div>
                <!-- <div class="mb-3">
                    <label for="password">密碼</label>
                    <input id="password" type="text" name="customerPassword" class="form-control" >
                </div> -->
                <div class="mb-3">
                    <label for="name">姓名</label>
                    <input id="name" type="text" name="customerName" class="form-control" value="<?=$row["customerName"]?>">
                </div>
                <div class="mb-3">
                    <label for="gender">性別</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="customerGender" id="" value="<?=$row["customerGender"]?>">
                            <label class="form-check-label" for="inlineRadio1">male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="customerGender" id="" value="<?=$row["customerGender"]?>">
                            <label class="form-check-label" for="inlineRadio1">female</label>
                        </div>
                </div>
                <div class="mb-3">
                <label for="birthday">出生日期</label>
                    <input id="Birthday" type="date" name="customerBday" class="form-control" value="<?=$row["customerBday"]?>">                                                        
                </div>
                <div class="mb-3">
                    <label for="phone">電話</label>
                    <input id="phone" type="text" name="customerPhone" class="form-control" value="<?=$row["customerPhone"]?>">
                </div>
                <div class="mb-3">
                <label for="picture">照片</label>
                        <div class="figure ">  
                            <img class="img-fluid cover-fit" src="images/<?=$row["customerPic"]?>" alt="">
                        </div>                                                     
                </div>
                <button class="btn btn-primary" type="submit">送出</button>
                <a href="doDelete.php?customerID=<?=$row["customerID"]?>" class="btn btn-danger">刪除</a>
            </form>
            <?php endif; ?>               
    </div>
</div>
    <script>

    </script>
</body>
</html>

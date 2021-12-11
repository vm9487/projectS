<?php
if(isset($_GET["campOwnerID"])){
    $campOwnerID=$_GET["campOwnerID"];
}else{
    $campOwnerID=0;
}
require_once ("../db-connect.php");
$sql="SELECT * FROM camp_owner_list WHERE campOwnerID='$campOwnerID' AND campOwnerValid=1";
$result=$conn->query($sql);
$campOwnerExist=$result->num_rows;
?>
<!doctype html>
<html lang="en">
<head>
    <title>campowner-edit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="headpicimage.css">
</head>
<body>
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
    <script>

    </script>
</body>
</html>

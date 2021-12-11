<?php
if(isset($_GET["campOwnerID"])){
    $campOwnerID=$_GET["campOwnerID"];
}else{
    $campOwnerID=0;
}

require_once ("../db-connect.php");
$sql="SELECT * FROM camp_owner_list WHERE campOwnerID='$campOwnerID'";
$result=$conn->query($sql);
$campOwnerExist=$result->num_rows;

?>
<!doctype html>
<html lang="en">
  <head>
    <title>campowner</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="headpicimage.css">
  </head>
  <body>
      <div class="container">
          <div class="row justify-content-center">              
              <div class="col-lg-8">
              <div class="py-2">
                  <a href="campowner-list.php" class="btn btn-primary">回列表</a>
              </div>
                  <?php if($campOwnerExist===0): ?>
                        營主不存在
                    <?php else: 
                        $row=$result->fetch_assoc();
                        ?>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>id</th>
                            <td><?=$row["campOwnerID"]?></td>
                        </tr>
                        <tr>
                            <th>帳號</th>
                            <td><?=$row["campOwnerAccount"]?></td>
                        </tr>
                        <tr>
                            <th>姓名</th>
                            <td><?=$row["campOwnerName"]?></td>
                        </tr>
                        <tr>
                            <th>性別</th>
                            <td><?php if ($row["campOwnerGender"] ==0) {
                                echo 'female' ;
                                }else {
                                echo 'male';
                            } 
                       ?></td>
                        </tr>
                        <tr>
                            <th>生日</th>
                            <td><?=$row["campOwnerBday"]?></td>
                        </tr>
                        <tr>
                            <th>電話</th>
                            <td><?=$row["campOwnerPhone"]?></td>
                        </tr>
                        <tr>
                            <th>公司名稱</th>
                            <td><?=$row["campOwnerCompanyName"]?></td>
                        </tr>
                        <tr>
                            <th>照片</th>
                            <td>
                            <div class="figure ">  
                        <img class="img-fluid cover-fit" src="images/<?=$row["campOwnerPic"]?>" alt="">
                            </div>   
                            </td>
                        </tr>
                        <tr>
                            <th>建立時間</th>
                            <td><?=$row["campOwnerCreatedTime"]?></td>
                        </tr>
                    </table>

                    <?php endif; ?>
              </div>
          </div>
      </div>
  </body>
</html>
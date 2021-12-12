<?php
require_once ("../db-connect.php");
$sql="SELECT * FROM camp_owner_list WHERE campOwnerValid=1";
$result=$conn->query($sql);
$camp_owner_listCount=$result->num_rows;



if(isset($_GET["s"])){
  $search=$_GET["s"];
  $sql="SELECT * FROM campowner_list WHERE name LIKE '%$search%'";
}
?>


<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="headpicimage.css">
  </head>
  <body>
  <div class="container">
          <div class="py-2">
              共 <?=$camp_owner_listCount?> 位營主
          </div>
          <div class="py-2">
            <label for="">搜尋</label>
            <form action="campowner-list.php" method="get">
              <div class="align-items-center">
                <input type="search" class="form-control" name="s">
                <button type="submit" class="btn btn-primary" text-nowrap>搜尋</button>
              </div>
            </form>
          </div>
          <table class="table table-bordered table-sm">
              <thead>
                  <tr>
                      <th>id</th>
                      <th>帳號</th>
                      <!-- <th>密碼</th> -->
                      <th>姓名</th>
                      <th>性別</th>
                      <th>生日</th>
                      <th>電話</th>
                      <th>公司名稱</th>
                      <th>照片</th>                      
                      <th>建立時間</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <?php if($camp_owner_listCount>0): 
                    while($row=$result->fetch_assoc()):
                    ?>
                  <tr>
                      <td><?=$row["campOwnerID"]?></td>
                      <td><?=$row["campOwnerAccount"]?></td>
                      <!-- <td><?=$row["customerPassword"]?></td> -->
                      <td><?=$row["campOwnerName"]?></td>
                      
                      <td><?php if ($row["campOwnerGender"] ==0) {
                      echo 'female' ;
                      }else {
                        echo 'male';
                       } 
                       ?> </td>
                      <td><?=$row["campOwnerBday"]?></td>
                      <td><?=$row["campOwnerPhone"]?></td>
                      <td><?=$row["campOwnerCompanyName"]?></td>

                      <td>                      
                      <div class="figure ">  
                        <img class="img-fluid cover-fit" src="images/<?=$row["campOwnerPic"]?>" alt="">
                      </div>                             
                      </td>
                      <td><?=$row["campOwnerCreatedTime"]?></td>
                      <td>
                        <a class="btn btn-primary" href="campowner.php?campOwnerID=<?=$row["campOwnerID"]?>">個人資訊</a>
                        <a class="btn btn-primary" href="campowner-edit.php?campOwnerID=<?=$row["campOwnerID"]?>">修改</a>
                      </td>
                  </tr>
                  <?php endwhile; ?>
                  <?php else: ?>
                    <tr>
                        <td colspan="8">沒有資料</td>
                    </tr>
                  <?php endif; ?>  
              </tbody>
          </table>
      </div>
  </body>
</html>
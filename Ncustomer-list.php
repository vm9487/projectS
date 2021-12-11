<?php
require_once ("../db-connect.php");
$sql="SELECT * FROM customer_list WHERE customerValid=1";


$result=$conn->query($sql);
$customer_listCount=$result->num_rows;

?>
<!doctype html>
<html lang="en">
  <head>
    <title>customer-list</title>
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
              共 <?=$customer_listCount?> 位消費者
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
                      <th>照片</th>
                      <th>建立時間</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <?php if($customer_listCount>0): 
                    while($row=$result->fetch_assoc()):
                    ?>
                  <tr>
                      <td><?=$row["customerID"]?></td>
                      <td><?=$row["customerAccount"]?></td>
                      <!-- <td><?=$row["customerPassword"]?></td> -->
                      <td><?=$row["customerName"]?></td>
                      <td>
                      <?php if ($row["customerGender"] ==0) {
                      echo 'female' ;
                      }else {
                        echo 'male';
                       } 
                       ?>
                      </td>
                      <td><?=$row["customerBday"]?></td>
                      <td><?=$row["customerPhone"]?></td>
                      
                      <td>                      
                      <div class="figure ">  
                        <img class="img-fluid cover-fit" src="images/<?=$row["customerPic"]?>" alt="">
                      </div>                             
                      </td>
                      <td><?=$row["customerCreatedTime"]?></td>
                      <td>
                        <a class="btn btn-primary" href="customer.php?customerID=<?=$row["customerID"]?>">個人資訊</a>
                        <a class="btn btn-primary" href="customer-edit.php?customerID=<?=$row["customerID"]?>">修改</a>
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
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>
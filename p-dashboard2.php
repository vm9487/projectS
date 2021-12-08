<?php
require_once("../db-PDOconnect4project.php");
if ((isset($_SESSION["user"])) OR (isset($_SESSION["usercamp"])) OR (isset($_SESSION["usersuper"])) )
{
//    var_dump($_SESSION["user"]);
//    var_dump($_SESSION["user"]["customerID"]);
//    var_dump($_SESSION["usercamp"]);
//    var_dump($_SESSION["usersuper"]);
}else{
    header("location: p-login.php");
}

///////////////////////////////////////////////////////////////////////
if (isset($_SESSION["user"])){
$id=$_SESSION["user"]["customerID"];
$sqlIncomingorder = "SELECT * FROM order_detail WHERE customerID=? AND orderStatusID=1";
$stmtIncomingorder = $db_host->prepare($sqlIncomingorder);
try {
    $stmtIncomingorder->execute([$id]);
    $rowIncomingorder = $stmtIncomingorder->rowCount();
//    var_dump($rowIncomingorder);
} catch (PDOException $e) {echo $e->getMessage();};
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
    } catch (PDOException $e) {echo $e->getMessage();};

}elseif(isset($_SESSION["usercamp"])){
//    echo"usercamp";

    $id=$_SESSION["usercamp"]["campOwnerID"];
    $sqlIncomingorderc = "SELECT order_detail.*, camp_list.* 
FROM order_detail JOIN camp_list ON order_detail.campID=camp_list.campID
WHERE camp_list.campOwnerID=?";
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
    } catch (PDOException $e) {echo $e->getMessage();};

}elseif(isset($_SESSION["usersuper"])){
//    echo"super";

}else{
    echo"nothing";

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
    .headbox{
        width: 200px;
        height: 200px;
        border-radius: 50%;
        padding:2px;
        border: 8px solid var(--bgcolor);
    <?php if (isset($_SESSION["user"])): ?>
        background: url("upload/<?=$rowheadpic["headpicFilename"]?>");
    <?php elseif (isset($_SESSION["usercamp"])): ?>
        background: url("upload/<?=$rowheadpicb["headpicFilename"]?>");
    <?php elseif (isset($_SESSION["usersuper"])):  ?>
        background: url("img/pepe.png");
    <?php else: ?>
    <?php endif; ?>


        background-repeat: no-repeat;
        background-position:center;
        background-size: contain;
        transition:0.5s;

    }
    .headbox:hover{
    <?php if (isset($_SESSION["user"])): ?>
        background:
                linear-gradient(180deg, rgba(0, 0, 0, 0) 10%,
                var(--asidecolor)), url("upload/<?=$rowheadpic["headpicFilename"]?>");
    <?php elseif (isset($_SESSION["usercamp"])): ?>
        background:
                linear-gradient(180deg, rgba(0, 0, 0, 0) 10%,
                var(--asidecolor)), url("upload/<?=$rowheadpicb["headpicFilename"]?>");
    <?php elseif (isset($_SESSION["usersuper"])):  ?>
        background:
                linear-gradient(180deg, rgba(0, 0, 0, 0) 10%,
                var(--asidecolor)), url("img/pepe.png");
    <?php else: ?>
    <?php endif; ?>

        background-repeat: no-repeat;
        background-position:center;
        background-size: contain;
        cursor: pointer;
    }
    .changepic{
        margin:120px 0px 0px 0px;
        text-decoration: none;
        display: flex;
        width: 180px;
        /*height: 200px;*/
        padding:0px;
        color:whitesmoke;
        justify-content: center;
        align-items: end;
    }
    .changepic:hover{
        text-decoration: none;
        color:whitesmoke;
    }

    aside{
        background-color:var(--asidecolor) ;
        min-height: 100vw;
    }
    .block{
        background: whitesmoke;
        border-radius: 0 20px 20px 0px;
        color:var(--acolor)
    }
    .hello{
        color:var(--asidecolor);
        font-weight: bold;
        font-size: 30px;
        margin-left:30px;    }
    .remind{
        
        font-weight: bold;
        font-size: 30px;
        margin-left:30px;
        background-color:var(--asidecolor);
        border-radius:5px;
        padding:5px; 
        
       }
    .remind a{
        text-decoration:none;
        color:whitesmoke;}
    .displayh{
        display:none;
    }
    .welcomes{
        font-weight: bold;
        font-size: 30px;
        margin-left:30px;
        color:var(--asidecolor);
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
                            <a href=""><?=$_SESSION["user"]["customerName"]?></a>
                        <?php elseif (isset($_SESSION["usercamp"])): ?>
                            <a href=""><?=$_SESSION["usercamp"]["campOwnerName"]?></a>
                        <?php elseif (isset($_SESSION["usersuper"])):  ?>
                            <a href=""><?=$_SESSION["usersuper"]["superadminAccount"]?></a>
                        <?php else: ?>
                        <?php endif; ?>
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
<?php if (isset($_SESSION["user"])): ?>
<div class="block py-2 my-2">管理首頁</div>
<div class="block py-2 my-2">你的訂單</div>
 
<?php elseif (isset($_SESSION["usercamp"])): ?>
<div class="block py-2 my-2">管理首頁</div>
 <div class="block py-2 my-2">營地訂單</div>
<div class="block py-2 my-2">業績檢視</div>
<div class="block py-2 my-2">營地管理</div>
<div class="block py-2 my-2">活動列表</div>

<?php elseif (isset($_SESSION["usersuper"])):  ?>
<div class="block py-2 my-2">管理首頁</div>
<div class="block py-2 my-2">顧客管理</div>
<div class="block py-2 my-2">營主管理</div>
<div class="block py-2 my-2">營地分類管理</div>
 
 <?php else: ?> <?php endif; ?>


                    </aside>



                </div><!-- col-4 -->
                <div class="col-lg-10">
                    <main class="d-flex justify-content-between m-2 flex-column">
                        <div class="d-flex justify-content-between m-2">

                        <div class="d-flex align-items-center ">
                            <div class="headbox">
                                <a class=" font-weight-bold changepic displayh " id="changepicbox"  href="#" onclick="window.open(' changepic.php ', 'uploadpic', config='height=400,width=600');" >click to change</a>
                            </div>

                        <?php if (isset($_SESSION["user"])): ?>
                            <div>
                             <div class="hello">Hi, <?=$_SESSION["user"]["customerName"]?></div>
                                <?php if ($rowIncomingorder>0): ?>
                             <div class="remind">
                                 <span class="material-icons text-light fs-4 mx-2">notifications</span>
                                <a href="">你七天內有<?=$rowIncomingorder;?>筆要成行的計畫! 快到你的訂單去看</a>
                             </div><!--remind-->

                                <?php else: ?>
                                <p class="welcomes">Welcome back!</p>
                                <?php endif; ?>
                           </div>

                        <?php elseif (isset($_SESSION["usercamp"])): ?>
                        <div>
                            <div class="hello">Hi, <?=$_SESSION["usercamp"]["campOwnerName"]?></div>

                            <?php if ($rowIncomingorderc>0): ?>
                                <div class="remind">
                                    <span class="material-icons text-light fs-4 mx-2">notifications</span>
                                    <a href="">你七天內有<?=$rowIncomingorderc;?>筆要招待的客人! 快到營地訂單去看</a>
                                </div>
                            <?php else: ?>
                                <p class="welcomes">Welcome back!</p>
                            <?php endif; ?>
                        </div>

                        <?php elseif (isset($_SESSION["usersuper"])):  ?>
                            <div class="hello">Hi, <?=$_SESSION["usersuper"]["superadminAccount"]?></div>
                        <?php else: ?>

                        <?php endif; ?>
                         </div>

                            <div><a href="doLogout.php" class="btn btn-primary ">log out</a></div>

                        </div>

                    </main>
                </div><!-- col-8 -->
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
    let changepicbox=document.querySelector("#changepicbox")
    let headbox=document.querySelector(".headbox")
    headbox.addEventListener("mouseover", function(){
        changepicbox.classList.remove("displayh");
    })
    headbox.addEventListener("mouseleave", function(){
        changepicbox.classList.add("displayh");
    })
    // --------------------------

</script>

</html>
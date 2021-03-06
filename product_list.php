<?php
// require_once ("../pdo_connect.php");
require_once("../db-PDOconnect4project.php");
// if ((isset($_SESSION["user"])) or (isset($_SESSION["usercamp"])) or (isset($_SESSION["usersuper"]))) {
// //    var_dump($_SESSION["user"]);
// //    var_dump($_SESSION["user"]["customerID"]);
// //    var_dump($_SESSION["usercamp"]);
// //    var_dump($_SESSION["usersuper"]);
// } else {
//     header("location: p-login.php");
// }

///////////////////////////////////////////////////////////////////////
if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"]["customerID"];
  
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
    // echo "nothing";

};
////////////////////////////////////////////////////////////////////////



$sql="SELECT * FROM camp_list WHERE campValid=1";
$stmt=$db_host->prepare($sql);
try {
    $stmt->execute();
    $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $rowCount=$stmt->rowCount();
}catch (PDOException $e){
    echo $e->getMessage();
}


//??????1
$sqlCate1="SELECT * FROM campCate1";
$stmtCate1=$db_host->prepare($sqlCate1);
try {
    $stmtCate1->execute();
    $rowCate1=$stmtCate1->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e){
    echo $e->getMessage();
}
//????????????
$sqlRegion="SELECT * FROM camp_region";
$stmtRegion=$db_host->prepare($sqlRegion);
try {
    $stmtRegion->execute();
    $rowRegion=$stmtRegion->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e){
    echo $e->getMessage();
}
//????????????
for ($i=1; $i<=4; $i++){
    ${"sqlCounty".$i}="SELECT * FROM camp_county WHERE campRegionID=?";
    ${"stmtCounty".$i}=$db_host->prepare(${"sqlCounty".$i});
    try {
        ${"stmtCounty".$i}->execute([$i]);
        ${"rowCounty".$i}=${"stmtCounty".$i}->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
//??????3
$sqlCate3="SELECT * FROM campCate3";
$stmtCate3=$db_host->prepare($sqlCate3);
try {
    $stmtCate3->execute();
    $rowCate3=$stmtCate3->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e){
    echo $e->getMessage();
}


//--------------------????????????--------------------
$conditions = [];
$parameters = [];

//????????????
if (empty($_GET["minPrice"])){
    $_GET["minPrice"]=0;
}
if (empty($_GET["maxPrice"])){
    $_GET["maxPrice"]=9999;
}
$_GET["minPrice"]=(int)$_GET["minPrice"];
$_GET["maxPrice"]=(int)$_GET["maxPrice"];
if (isset($_GET["minPrice"]) && isset($_GET["maxPrice"]))
{
    $conditions[] = 'campPrice >=? AND campPrice <=?';
    $parameters[] = $_GET["minPrice"];
    $parameters[] = $_GET["maxPrice"];
}
//??????
if (!empty($_GET['search']))
{
    $conditions[] = 'campName LIKE ?';
    $parameters[] = '%'.$_GET['search']."%";
}
//????????????cate1
if (!empty($_GET['cate1']))
{
    $conditions[] = 'campCate1ID = ?';
    $parameters[] = $_GET['cate1'];
}
//????????????
if (!empty($_GET['county']))
{
    $conditions[] = 'campCountyID = ?';
    $parameters[] = $_GET['county'];
}
//????????????cate3
if (!empty($_GET['cate3']))
{
    $conditions[] = 'campCate3ID = ?';
    $parameters[] = $_GET['cate3'];
}


// the main query
$sqlFilter = "SELECT * FROM camp_list";

// ?????????????????? query ??????
if ($conditions)
{
    $sqlFilter .= " WHERE ".implode(" AND ", $conditions)." AND campValid=1";
}

// the usual prepare/execute/fetch routine
$stmtFilter = $db_host->prepare($sqlFilter);
//????????????
$stmtFilter->execute($parameters);
$row = $stmtFilter->fetchAll(PDO::FETCH_ASSOC);



?>


<!doctype html>
<html lang="en">

<head>
    <title>Product list</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css">
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

    /*??????*/
.cover-fit{
    height: 100%;
    width: 100%;
    object-fit: cover;
}
a {
    text-decoration: none;
    color: #000;
}

/*??????*/
.ellipsis {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>

</head>

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

                    <a href="p-dashboard2.php">????????????</a>
                </nav>
            </div>
        </div><!-- row -->
    </div><!-- container -->
</header>

<div class="mainsection">
    <div class="container">
    <h2 class="mt-3">????????????</h2>
<!--            <h4>????????????</h4>-->
            <div>
                <div class="mt-3">
                    <label for="">??????</label>
                    <form action="product_list.php" method="get">
                        <div class="d-flex align-items-center">
                            <div class="col-auto me-2">
                                <input type="search" class="form-control" name="search" value="<?php if(isset($search))echo $search; ?>">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">??????</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-3">
                    <label for="">??????</label>
                    <form action="product_list.php" method="get">
                        <div class="d-flex align-items-center">
                            <div class="col-auto me-2">
                                <input type="number" class="form-control" name="minPrice" value="<?=$_GET["minPrice"]?>">
                            </div>
                            <div class="col-auto me-2">~</div>
                            <div class="col-auto me-2">
                                <input type="number" class="form-control" name="maxPrice" value="<?=$_GET["maxPrice"]?>">
                            </div>
                            <div class="col-auto me-2">
                                <button type="submit" class="btn btn-primary">??????</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-3">
                    <label for="">??????</label>
                    <div>
                        <h5>
                        <?php
                        foreach ($rowCate1 as $value):
                        ?>
                            <a class="badge text-white me-1 <?php if(isset($_GET['cate1']) && $_GET['cate1']==$value["campCate1ID"]){echo "bg-primary";}else{echo  "bg-info";}  ?>" href="product_list.php?cate1=<?=$value["campCate1ID"]?>"><?=$value["campCate1item"]?></a>
                        <?php
                        endforeach;
                        ?>
                        </h5>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="">??????</label>
                    <div class="d-flex">
                        <?php
                        foreach ($rowRegion as $value):
                            ?>
                            <div class="dropdown me-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?=$value["campRegion"]?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <form action="product_list.php" method="get">
                                        <?php
                                        foreach (${"rowCounty".$value["campRegionID"]} as $value):
                                            ?>
                                            <li><a class="dropdown-item" href="product_list.php?county=<?=$value["campCountyID"]?>"><?=$value["campCounty"]?></a></li>
                                        <?php
                                        endforeach;
                                        ?>
                                    </form>
                                </ul>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="">??????</label>
                    <div>
                        <h5>
                            <?php
                            foreach ($rowCate3 as $value):
                                ?>
                                <a class="badge text-white me-1 <?php if(isset($_GET['cate3']) && $_GET['cate3']==$value["campCate3ID"]){echo "bg-primary";}else{echo "bg-info";}  ?>" href="product_list.php?cate3=<?=$value["campCate3ID"]?>"><?=$value["campCate3item"]?></a>
                            <?php
                            endforeach;
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="mt-3">
                    <a role="button" class="btn btn-danger" href="product_list.php">????????????</a>
                </div>
            </div>

<!--            ??????????????????????????????-->
            <form action="product_intro.php" method="get">
                <div class="row mt-3">
                    <?php
                    if ($rowCount>0):
                        foreach ($row as $value):
                            ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card m-3">
                                    <a href="product_intro.php?campID=<?=$value["campID"]?>">
                                        <figure class="m-0 ratio ratio-4x3">
                                            <img  class="cover-fit" src="upload/<?=$value["campPic"]?>" alt="">
                                        </figure>
                                        <div class="m-3">
                                            <h4><?=$value["campName"]?></h4>
                                            <h6>$<?=$value["campPrice"]?></h6>
                                            <p class="ellipsis"><?=$value["campDes"]?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
<!--                    ??????-->
                        <?php if(isset($p)): ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <?php for($i=1; $i<=$pageCount; $i++): ?>
                                    <li class="page-item <?php if($p==$i)echo "active" ?>"><a class="page-link" href="product_list.php?p=<?=$i?>"><?=$i?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
<!--                    end-->
                    <?php
                    else:
                    ?>
                        <tr>
                            <td colspan="4">????????????</td>
                        </tr>
                    <?php
                    endif;
                    ?>
                </div>
            </form>

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
    let changepicbox = document.querySelector("#changepicbox")
    let headbox = document.querySelector(".headbox")
    headbox.addEventListener("mouseover", function () {
        changepicbox.classList.remove("displayh");
    })
    headbox.addEventListener("mouseleave", function () {
        changepicbox.classList.add("displayh");
    })
    // --------------------------

</script>

</html>
<?php
require_once("../db-PDOconnect.php");
if ((isset($_SESSION["user"])) OR (isset($_SESSION["usercamp"])) OR (isset($_SESSION["usersuper"])) )
{
//    var_dump($_SESSION["user"]);
//    var_dump($_SESSION["usercamp"]);
//    var_dump($_SESSION["usersuper"]);
}else{
        header("location: p-login.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .cover-fit{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="justify-content-end f-flex">
        <?php if (isset($_SESSION["user"])): ?>
        <div>hi, <?=$_SESSION["user"]["customerName"]?></div>
        

        <?php elseif (isset($_SESSION["usercamp"])): ?>
            <div>hi, <?=$_SESSION["usercamp"]["campOwnerName"]?></div>

        <?php elseif (isset($_SESSION["usersuper"])):  ?>
            <div>hi, <?=$_SESSION["usersuper"]["superadminAccount"]?></div>
        <?php else: ?>

        <?php endif; ?>
        <a href="doLogout.php" class="btn btn-primary">log out</a>
    </div>
    </div>
</div>
</body>
</html>
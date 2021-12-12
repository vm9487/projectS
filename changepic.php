<?php
require_once("../db-PDOconnect4project.php");
if ((isset($_SESSION["user"])) OR (isset($_SESSION["usercamp"])) )
{
//    var_dump($_SESSION["user"]);
//    var_dump($_SESSION["user"]["customerID"]);
//    var_dump($_SESSION["usercamp"]);
//    var_dump($_SESSION["usersuper"]);
}else{
    header("location: p-login.php");
}
if (isset($_SESSION["user"])):
    $sql = "SELECT * FROM upload_headpic WHERE customerID=? AND headpicValid=1 ORDER BY headpicID DESC";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$_SESSION["user"]["customerID"]]);
        $row = $stmt->fetch();
//        var_dump($row["headpicFilename"]);
//        echo "hello";

    } catch (PDOException $e) {
        echo $e->getMessage();
    };
elseif(isset($_SESSION["usercamp"])):
    $sqlcamp = "SELECT * FROM upload_headpic WHERE campOwnerID=? AND headpicValid=1 ORDER BY headpicID DESC";
    $stmtcamp = $db_host->prepare($sqlcamp);
    try {
        $stmtcamp->execute([$_SESSION["usercamp"]["campOwnerID"]]);
        $rowcamp = $stmtcamp->fetch();
//        var_dump($rowcamp["headpicFilename"]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    };
else:;
endif;;
?>

<!doctype html>
<html lang="en">
<head>
    <title>Change pic</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<form action="doUploadHeadpic.php" method="post" enctype="multipart/form-data">
    <div class="mb-2">
        <label for=""></label>
        <input type="file" class="form-control" name="myFile" required>
    </div>
    <button id="btn" class="btn btn-primary" type="submit">
     更新
    </button>
</form>

</body>
</html>


<script>
    // self.close();

</script>

<?php
require_once("../db-PDOconnect4project.php");

// var_dump($_FILES["myFile"]);
if ($_FILES["myFile"]["error"] === 0) {

    if (move_uploaded_file($_FILES["myFile"]["tmp_name"], "upload/" . $_FILES["myFile"]["name"])) {
//        echo "upload succeed";
        $now = date("Y-m-d H:i:s");
        $filename = $_FILES["myFile"]["name"];
        ////////////////////

        if (isset($_SESSION["user"])) {
            $user_id = $_SESSION["user"]["customerID"];
            $sql = "INSERT INTO upload_headpic (customerID, headpicFilename, headpicUploaded_at, headpicValid) VALUES (?, ? ,? , 1)";
            $stmt = $db_host->prepare($sql);
            try {
                $stmt->execute([$user_id, $filename, $now]);
            } catch (PDOException $e) {echo $e->getMessage();};
            echo "successfully uploaded";
            echo '<script> self.opener.location.reload();</script>';
            echo '<script>window.close();</script>';
        } elseif (isset($_SESSION["usercamp"])) {
            $user_id = $_SESSION["usercamp"]["campOwnerID"];
            $sqlc = "INSERT INTO upload_headpic (campOwnerID, headpicFilename, headpicUploaded_at, headpicValid) VALUES (?, ? ,? , 1)";
            $stmtc = $db_host->prepare($sqlc);
            try {
                $stmtc->execute([$user_id, $filename, $now]);
            } catch (PDOException $e) {
                echo $e->getMessage();
            };
            echo "successfully uploaded";
            echo '<script> self.opener.location.reload();</script>';
            echo '<script>self.close();</script>';
        }else{ echo"please try again later";};
    } else {
        echo "upload failed";
    }
}
//如果指定目的地沒有會失敗
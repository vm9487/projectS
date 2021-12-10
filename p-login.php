<?php

require_once("../db-PDOconnect4project.php");
//if (isset($_SESSION["user"])) {
//    header("location: 1.dashboard.php");
//}


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
        --webname: "Glamping"
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

    aside {
        background-color: var(--asidecolor);
        min-height: 100vw;
    }

    .block {
        background: whitesmoke;
        border-radius: 0 20px 20px 0px;
        color: var(--acolor);
    }

    .login {
        background: var(--asidecolor);
        width: 40vw;
        margin: 30px 0;
        border-radius: 0 20px 20px 0px;
    }

    .loginpic {
        margin: 30px 0;
        min-width: 600px;
        border-radius: 10px;
        background: aquamarine;
        border-radius: 20px 0px 0px 20px;
        overflow: hidden;
    }

    .loginsm {
        width: 500px;
    }

    .signinbttn {
        width: 250px
    }

    .fgpwd {
        font-size: 15px;
        margin-left: 130px;

    }
    .line{
        width:500px;
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

                    <a href="product_list.php">回網站首頁</a>
                </nav>
            </div>
        </div><!-- row -->
    </div><!-- container -->
</header>

<div class="mainsection">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-center">
                    <div class="loginpic">
                        <img class="img-fluid " src="img/glamping1.jpg" alt="">
                    </div>
                    <div class="login d-flex justify-content-center align-items-center flex-column">
                        <h1 class="text-light fst-italic">Welcome to Glamping </h1>
                        <form class="d-flex justify-content-center align-items-center flex-column" action="doLogin2.php" method="post">
                            <?php $maxErrorTime = 2; ?>
                            <?php if (isset($_SESSION["error_time"]) && $_SESSION["error_time"] > $maxErrorTime) : ?>
                                <h2>登入錯誤太多次</h2>
                                <a class="text-decoration-none  align-self-center fw-5 ">forget password?</a>
                            <?php else: ?>
                            <h2 class="text-light">Please log in to continue</h2>
                            <div class="loginsm d-flex justify-content-center flex-column align-items-center">
                                <div class="form-floating input-up">
                                    <input class=" form-control emailinput1 py-2 px-3 mt-2" type="email"
                                           placeholder="email" name="email">
                                    <label for="floatingInput">Your email address</label>
                                </div>
                                <!--                            ------------------------------------------------->
                                <div class="form-floating input-buttom">
                                    <input class=" form-control psw py-2 px-3 mt-2" type="password"
                                           placeholder="password" name="password">
                                    <label for="floatingInput">Password</label>
                                </div>
                                <?php if (isset($_SESSION["error_msg"])): ?>
                                    <div class="text-danger"><?= $_SESSION["error_msg"] ?><br>剩餘可嘗試登入次數:
                                        <?php
                                        $trytime = $maxErrorTime - $_SESSION["error_time"] + 1;
                                        echo $trytime; ?> </div>
                                    <?php
                                    unset($_SESSION["error_msg"]);
                                endif; ?>
                                <!--                            ------------------------------------------->
                            </div>
                            <a class="text-decoration-none  align-self-center fgpwd ">forget password?</a>

                            <div class="d-flex pb-2">
                                <button  class="m-2 signinbttn btn btn-light btn-sm" type="submit">Log in
                                </button>

                            </div>
                        </form>
                        
                        <div class="line"><img class="img-fluid " src="img/mtnline.png" alt=""></div>

                        <a href="p-signup.php" class="my-4 mx-2 signinbttn btn btn-light btn-sm" type="submit">Sign up
                        </a>
                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div><!-- col-12 -->
    </div><!-- row -->

</div><!-- container -->

</div><!-- mainsection -->


<!-- Bootstrap JavaScript Libraries -->
<script src=" https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>

</html>
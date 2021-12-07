<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
        color: var(--acolor)
    }

    main {
        background: var(--asidecolor);
        margin: 20px auto;
        width: 1200px;
        border-radius: 20px;

    }

    .displayh {
        display: none;
    }
    label{
        color:whitesmoke;
        font-weight: bold;

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
                    <a href="">username</a>
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
            <div class="col-lg-12">
                <main class="justify-content-center d-flex flex-column align-items-center flex-column">

                    <h1 class="text-light fw-bold my-2">Just a few steps away to join us...</h1> <br>


                    <div class="">
                        <form class="g-5" action="doSignupcampowner.php" method="post">

                            <div class="row mb-1">

                                <label class="col-form-label col-sm-3" for="account">Account</label>
                                <div class="col-sm-9">
                                    <input id="account" type="text" name="account" class="form-control "
                                           placeholder="name@example.com">
                                </div>

                            </div>

                            <div class=" row mb-3">
                                <label class="col-form-label col-sm-3" for="name">Name</label>
                                <div class="col-sm-9">
                                    <input id="name" type="name" name="name" class="form-control"></div>
                            </div>

                            <div class="mb-1">
                                <label for="Gender">Gender</label>
                                <!--                            ------------------->
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="gender " id="gender">
                                    <label class="form-check-label" for="male">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="gender" id="gender">
                                    <label class="form-check-label" for="Female">
                                        Female
                                    </label>
                                </div>

                                <!--                            --------------------->
                            </div>

                            <div class="mb-1 row">
                                <label class="col-form-label col-sm-3" for="Birthday">Birthday</label>
                                <div class="col-sm-9">
                                    <input id="Birthday" type="date" name="Birthday" class="form-control">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-form-label col-sm-3" for="Phone">Phone</label>
                                <div class="col-sm-9">
                                    <input id="Phone" type="Phone" name="Phone" class="form-control">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-form-label col-sm-3" for="password">Password</label>
                                <div class="col-sm-9">
                                    <input id="password" type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="mb-1 row align-items-center">
                                <label class="col-form-label col-sm-3" for="repassword">Re-enter your password</label>
                                <div class="col-sm-9">
                                    <input required id="repassword" type="password" name="repassword"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gt-5">
                            <button class="btn btn-light m-3" type="submit">Join!</button>
                            <a href="p-login.php" class="btn btn-light m-3" type="submit">I'll think about it</a>
                            </div>
                        </form>


                    </div>


                </main>
            </div><!-- col-10 -->
        </div><!-- row -->

    </div><!-- container -->

</div><!-- mainsection -->


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<script>
    $(".fotochoose").hover(function () {
        $(this).find("span").removeClass("displayh");
        $(this).find("img").addClass("darken")
    });
    $(".fotochoose").mouseleave(function () {
        $(this).find("span").addClass("displayh");
        $(this).find("img").removeClass("darken")
    });


</script>


</body>
</html>
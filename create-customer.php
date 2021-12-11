<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="d-flex justify-content-center">
        <h2>後台管理系統</h2>
    </div>
<div class="container">
    <div class="py-2 d-flex justify-content-end">
        <div>
            <a class="btn btn-primary" href="user-list.php">使用者列表</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="doInsert.php" method="post">
                <div class="mb-3">
                    <label for="account">帳號</label>
                    <input id="account" type="text" name="customerAccount" class="form-control" >
                </div>
                <!-- <div class="mb-3">
                    <label for="password">密碼</label>
                    <input id="password" type="text" name="customerPassword" class="form-control" >
                </div> -->
                <div class="mb-3">
                    <label for="name">姓名</label>
                    <input id="name" type="text" name="customerName" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="gender">性別</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="customerGender" id="" value="1">
                            <label class="form-check-label" for="inlineRadio1">male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="customerGender" id="" value="0">
                            <label class="form-check-label" for="inlineRadio1">female</label>
                        </div>
                </div>
                <div class="mb-3">
                
                    <input id="Birthday" type="date" name="customerBday" class="form-control">
                
                </div>
                <button class="btn btn-primary" type="submit">送出</button>
            </form>               
    </div>
</div>
    <script>

    </script>
</body>
</html>

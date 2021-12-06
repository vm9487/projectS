<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    aside{
        background-color:var(--asidecolor) ;
        min-height: 100vw;
    }
    .block{
        background: whitesmoke;
        border-radius: 0 20px 20px 0px;
        color:var(--acolor)
    }
    main{
        background: var(--asidecolor);
        min-height: 80vh;
        margin:20px auto;
        width:1200px;
        border-radius:20px;

    }
    .fotochoose{
        width: 270px;
        height: 270px;
        border-radius: 50%;
        margin: 30px;
        transition:0.8s;
        
        
    }


    .remarks{
        margin-top:-180px;
        color:whitesmoke;
        font-size: 35px;
        text-align: center;
        width: 280px;
        font-weight: bold;
       
    
    }

     .darken{
        opacity:0.3;
    }

    .fotochoose:hover .remarks{
        margin-top:-210px;
      
        opacity:1;
        text-shadow: 3px 3px 6px #333;
    } 
    .fotochoose:hover{
       
        text-decoration :none;
        
    } 

    .displayh{
        display:none;
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
                    
                    <h1 class="text-light fw-bold my-2">Welcome to Glamping</h1> <br>
                    <h1 class="text-light fw-bold my-2">What would you like to do with us?</h1>
            
                    <div class="d-flex">
                        <a href="" class="fotochoose d-flex flex-column align-items-center">
                            <img class="img-fluid" src="img/Graph-Magnifier-icon.png" alt="">
                        <span class="remarks displayh ">I'm seeking for business chance.</span>
                        </a>

                        <a href="" class="fotochoose d-flex flex-column align-items-center">
                            <img class="img-fluid" src="img/Flat-Tent.svg" alt="">
                            <span class="remarks displayh ">I'd like to have some fun!</span>
                        </a>


                    </div>



                </main>
            </div><!-- col-10 -->
        </div><!-- row -->

    </div><!-- container -->

</div><!-- mainsection -->
















      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
    $(".fotochoose").hover(function(){
        $(this).find("span").removeClass( "displayh" );
        $(this).find("img").addClass("darken")
    });
    $(".fotochoose").mouseleave(function(){
        $(this).find("span").addClass( "displayh" );
        $(this).find("img").removeClass("darken")
    });
    


</script>


  </body>
</html>
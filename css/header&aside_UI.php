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
</style>
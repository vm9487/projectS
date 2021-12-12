<?php
session_start();
unset($_SESSION["user"]);
unset($_SESSION["usercamp"]);
unset($_SESSION["usersuper"]);
header("location: p-login.php");
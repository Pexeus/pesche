<?php
if(isset($_POST["b-signout"])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php?signout=success");
    exit();
}
else{
    header("Location: ../index.php?error=accesDenied");
    exit();
}

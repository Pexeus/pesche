<?php
function auth($session){
    if(!isset($session["uid"])){
        header("Location: index.php?error=accessDenied");
        return FALSE;
        exit();
    }
    else{
        return TRUE;
    }
}





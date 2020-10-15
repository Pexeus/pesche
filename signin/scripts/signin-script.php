<?php
function get_user(){
            $conf= new stdClass();
            $conf->uid = 1;
            $conf->name = "admin";
            $conf->pwd = "$2y$12\$LeIbehisgf6HbQiPnD06zudZ/F9BgExs3qIT1TMyh9zTJzwyRcaHC";
            $conf_json = json_encode($conf);
            return $conf_json;
}
if(isset($_POST["signin-submit"])){
    if(isset($_POST["uid"]) && isset($_POST["pwd"]) && $_POST["uid"] != ""  && $_POST["pwd"] != ""){
        //require("../users/index.php");
        //$conf_user = get_user();
		$conf_user_json_raw = get_user();
        $json = json_decode($conf_user_json_raw);
        if($_POST["uid"] == $json->name){
            if(password_verify($_POST["pwd"],$json->pwd)){
                session_start();
                $_SESSION["uid"] = $json->uid;
                header("Location: ../../backend/index.php?signin=success");
                exit();
            }
            else{
                header("Location: ../index.php?error=wrongPassword&uid=".$_POST["uid"]);
                exit();
            }
        }
        else{
            header("Location: ../index.php?error=wrongCredentials");
        }
    }
    else{
        if(isset($_POST["uid"]) && $_POST["uid"] != ""){
            header("Location: ../index.php?error=emptyInputs&uid=".$_POST["uid"]);
            exit();
        }
        else{
            header("Location: ../index.php?error=emptyInputs");
            exit();
        }
    }
}
else{
	var_dump($_POST);
    //header("Location: ../index.php?error=accessDenied");
}
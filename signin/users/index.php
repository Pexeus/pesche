<?php
	function get_user(){
            $conf;
            $conf->uid = 1;
            $conf->name = "admin";
            $conf->pwd = "$2y$12\$LeIbehisgf6HbQiPnD06zudZ/F9BgExs3qIT1TMyh9zTJzwyRcaHC";
            $conf_json = json_encode($conf);

            return $conf_json;
    }
	if(isset($_POST["uid"]) && isset($_POST["pwd"])){
		
	}
	else{
		header("Location: ../index.php?error=accessDenied");
	}
    
    
<?php
if(isset($_GET['error'])){
    echo "<script>
        alert(\"[Error] ". $_GET["error"] ."\");
    </script>";
}
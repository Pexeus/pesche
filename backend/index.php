<?php
            session_start();
            if(!isset($_SESSION["uid"])){
                header("Location: ../signin/index.php");
                exit();
            }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="-1">
</head>
<body>
    <?php
        require("backend.php");
        require("loader.php");
    ?>

    <script src="./UI.js"></script>
</body>
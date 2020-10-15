<?php
            session_start();
            if(!isset($_SESSION["uid"])){
                header("Location: ../../signin/index.php");
                exit();
            }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive</title>
    <link rel="stylesheet" href="archive.css">
</head>
<body>
    <div id="header">
        <a href="../"><</a>
        <h1>Archiv</h1>
    </div>
    <?php
        require("./displayArchive.php")
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        $category = $_GET["category"];
        echo "<title>{$category}</title>";
    ?>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php

    require("./posts.php");

    ?>
</body>
</html>
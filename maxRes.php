<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="maxRes.css">
</head>
<body>

<script>
    document.body.addEventListener('click', () => {
        window.close();
    });
</script>

<?php
    if (isset($_POST["imagePath"])) {
        
        $dir = $_POST["imagePath"];

        $contents = scandir($dir);

        foreach ($contents as $content) {
            if ($content != "." && $content != ".." && $content != "compressed.jpeg" && $content != "data.txt") {
                $src = $dir . $content;

                echo "<img src=$src>";

                die;
            }
        }
    }
    else {
        header("Location: index.php");
    }
?>

</body>
</html>

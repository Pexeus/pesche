<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="backend.css">
</head>
<body>
    <div class="submitMenu">
        <div class="setCategory">
            <h1>Kategorie Festlegen</h1>
            <form action="save.php" method="post">
                <?php
                    $toRestore = $_POST["restore"];
                    $saveDir = "../../data/book/";

                    echo "
                        <input type=hidden name=path value={$toRestore}>
                    ";

                    insertCategories($saveDir);

                    function outputCategory($cat) {
                        echo "<input type=radio name=category value=$cat>
                            <label for=category>$cat</label><br>";
                    }

                    function insertCategories($saveDir) {
                        $categories = scandir($saveDir);
            
                        foreach ($categories as $category) {
                            if (is_dir($saveDir . $category) && $category != "." && $category != "..") {
                                outputCategory($category);
                            }
                        }
                    }
                ?>
                <input type="submit" value="Veröffentlichen" id="submit"> 
            </form>
        </div>
    </div>
</body>
</html>
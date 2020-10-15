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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="backend.css">
    <title>Backend</title>
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="-1">
</head>

<?php
    $path = "../" . $_POST["edit"];
    $currentImages = ["../../img/placeholder.png", "../../img/placeholder.png", "../../img/placeholder.png", "../../img/placeholder.png"];
    $currentImageTitles = ["", "", "", ""];
    $title = "";

    if (file_exists($path . "title.txt")) {
        $file = fopen($path . "title.txt", "r");
        
        $title = fread($file, filesize($path . "title.txt"));
    }

    foreach(glob($path . "*", GLOB_ONLYDIR) as $dir) {
        $currentStorage = $path . basename($dir);

        $imageDir = $currentStorage . "/compressed.jpeg";
        $dataFile = $currentStorage . "/data.txt";
        $imageIndex = (int) filter_var(basename($dir), FILTER_SANITIZE_NUMBER_INT);

        if (file_exists($dataFile)) {
            if (filesize($dataFile) > 0) {
                $file = fopen($dataFile, "r");
                $currentImageTitles[$imageIndex] = fread($file, filesize($dataFile));
            }
        }

        $currentImages[$imageIndex] = $imageDir;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="backend.css">
    <title>Backend</title>
</head>
<body>
    <div id="UploadSelection">
    <form action="process.php" method="post" enctype="multipart/form-data">
    <?php
        echo "<input type=hidden name=path value=" . $path . ">";
    ?>
        <div id="book">
            <div id="left">
                
                <div id="titleSelection">
                    <?php
                        echo "<input type=text placeholder=Titel name=titleInput value = \"" . $title. "\" >";
                    ?>
                </div>

                <div id="image1" class="imageSelector">
                    <div id="imageTitle">
                        <?php
                            echo "<input type=text placeholder=Bildüberschrift name = imageTitle_1 value = \"" . $currentImageTitles[0]. "\" >";
                            echo "<input type=hidden name=imageDel_1 value = false>";
                        ?>
                    </div>

                    <?php
                        echo "<img src = " . $currentImages[0] . " id=preview_image_1>";
                    ?>
                    <input type="file" name="image_1" id="imageInput" onchange="loadFile(event)">
                    <button type="button" id=toggleDeleteButton onclick="toggleDelete()">Löschen</button>
                </div>

                <div id="image2" class="imageSelector">
                    <div id="imageTitle">
                    <?php
                        echo "<input type=text placeholder=Bildüberschrift name = imageTitle_2 value = \"" . $currentImageTitles[1]. "\" >";
                        echo "<input type=hidden name=imageDel_2 value = false>";
                    ?>
                    </div>

                    <?php
                        echo "<img src = " . $currentImages[1] . " id=preview_image_2>";
                    ?>
                    <input type="file" name="image_2" id="imageInput" onchange="loadFile(event)">
                    <button type="button" id=toggleDeleteButton onclick="toggleDelete()">Löschen</button>
                </div>
            </div>

            <div id="right">

                <div id="void63"></div>

                <div id="image3" class="imageSelector">
                        <div id="imageTitle">
                        <?php
                            echo "<input type=text placeholder=Bildüberschrift name = imageTitle_3 value = \"" . $currentImageTitles[2]. "\" >";
                            echo "<input type=hidden name=imageDel_3 value = false>";
                        ?>
                        </div>

                        <?php
                        echo "<img src = " . $currentImages[2] . " id=preview_image_3>";
                    ?>
                        <input type="file" name="image_3" id="imageInput" onchange="loadFile(event)">
                        <button type="button" id=toggleDeleteButton onclick="toggleDelete()">Löschen</button>
                    </div>

                    <div id="image4" class="imageSelector">
                        <div id="imageTitle">
                        <?php
                            echo "<input type=text placeholder=Bildüberschrift name = imageTitle_4 value = \"" . $currentImageTitles[3]. "\" >";
                            echo "<input type=hidden name=imageDel_4 value = false>";
                        ?>
                        </div>

                        <?php
                        echo "<img src = " . $currentImages[3] . " id=preview_image_4>";
                    ?>
                        <input type="file" name="image_4" id="imageInput" onchange="loadFile(event)">
                        <button type="button" id=toggleDeleteButton onclick="toggleDelete()">Löschen</button>
                    </div>
                </div>
        </div>


        <div id="upload">
            <input type="submit" value="Speichern" name="submit">
        </div>
    </form>
    </div>
    <script src="./form.js"></script>
</body>
</html>
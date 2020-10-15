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
                    $saveDir = "../../data/book/";

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

                <input type="submit" value="Abschliessen" id="submit"> 
            </form>
        </div>
    </div>

    <div class="console">
    <?php
        echo "Starte Upload... <br> <br>";

        //upload target
        $tempDir = "../../data/temp/";

        //delete TMP
        delete_files($tempDir);

        //recreate TMP
        mkdir($tempDir);

        //form data names
        $formTextData = ["titleInput", "imageTitle_1", "imageTitle_2", "imageTitle_3", "imageTitle_4"];
        $images = ["image_1", "image_2", "image_3", "image_4"];

        //getting form text data
        for ($i = 0; $i < count($formTextData); $i++) {
            $formTextData[$i] = getPost($formTextData[$i]);
        }

        //getting form image data
        for ($i = 0; $i < count($images); $i++) {
            $images[$i] = getImage($images[$i]);
        }

        createFileStructure($tempDir, $formTextData, $images);

        //create folders and files
        function createFileStructure($tempDir, $formTextData, $images) {
            $titleData = fopen($tempDir . "title.txt", "w") or die("Fehler beim abspeichern: [PHP, fopen]");

            $noEntry = true;

            fwrite($titleData, $formTextData[0]);
            fclose($titleData);

            echo("> Erstelle " . $formTextData[0]);
            echo("<br>");

            for ($i = 0; $i < count($images); $i++) {
                if ($images[$i] != false) {
                    //creating folder
                    mkdir($tempDir . "IMG_" . $i);

                    //inserting image text
                    $imgageText = fopen($tempDir . "IMG_" . $i . "/data.txt", "w") or die("Fehler beim abspeichern: [PHP, fopen]");
                    fwrite($imgageText, $formTextData[$i + 1]);
                    fclose($imgageText);

                    echo "> Metadaten für " .  $formTextData[$i + 1] . " erstellt <br>";

                    //inserting image
                    uploadImage($images[$i], $tempDir . "IMG_" . $i . "/");

                    $noEntry = false;
                }
            }

            if ($noEntry == true) {
                error("Es muss mindestens ein Bild vorhanden sein");
            }

            echo("<br>");
            echo("<p id=green>> Alle Daten erfolgreich hochgeladen</p>");
            echo("<br>");
        }

        //fix filenames
        function fileName($originalName) {
            //replace spaces with underscores
            $noSpaces = preg_replace('/\s+/', '_', $originalName);

            $search = array("Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´");
            $replace = array("Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", "");

            $noBullshit = str_replace($search, $replace, $noSpaces);

            return $noBullshit;
        }

        //uploading images
        function uploadImage($image, $target) {
            //getting stuff
            $imageFileType = strtolower(pathinfo($image["name"],PATHINFO_EXTENSION));
            $fileTypes = ["png", "jpg", "jpeg"];
            $fileTypeValid = false;
            $legalFileTypes = "";
            $targetFile = $target . fileName($image["name"]);
            $targetFileCompressed = $target . "compressed.jpeg";

            //filetype check
            for ($i = 0; $i < count($fileTypes); $i++) { 
                if ($fileTypes[$i] == $imageFileType) {
                    $fileTypeValid = true;
                }

                $legalFileTypes .= " " . $fileTypes[$i];
            }

            if ($fileTypeValid == false) {
                error("Bildformat invalid, zulässige Formate: $legalFileTypes");
            }

            //size check
            if ($image["size"] > 10000000) {
                error("Dieses Bild ist zu gross! [" . $image["name"] . "]");
            }

            if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                echo "> " . basename($image["name"]). " wurde hochgeladen <br>";

                echo "> compressing " . $image["name"] . "...";

                compress($targetFile, $targetFileCompressed, 10);


            } else {
                echo "Technischer Fehler beim Upload!";
            }
        }

        function compress($source, $destination, $quality) {

            $exif = exif_read_data($source);
            $orientation = $exif['Orientation'];

            $info = getimagesize($source);
        
            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($source);
            }
        
            elseif ($info['mime'] == 'image/gif') {
                $image = imagecreatefromgif($source);
            }
        
            elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($source);
            }

            echo "<br><br>";
            print_r($orientation);
            echo "<br><br>";

            switch ($orientation) {
                case 2:
                    imageflip($image, IMG_FLIP_HORIZONTAL);
                    break;
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 4:
                    imageflip($image, IMG_FLIP_VERTICAL);
                    break;
                case 5:
                    $image = imagerotate($image, -90, 0);
                    imageflip($image, IMG_FLIP_HORIZONTAL);
                    break;
                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;
                case 7:
                    $image = imagerotate($image, 90, 0);
                    imageflip($image, IMG_FLIP_HORIZONTAL);
                    break;
                case 8:
                    $image = imagerotate($image, 90, 0); 
                    break;
            }
        
            imagejpeg($image, $destination, $quality);
        
            return $destination;
        }

        //get form data
        function getPost($name) {
            if (isset($_POST[$name]) && $_POST[$name] != "") {
                return $_POST[$name];
            }
            else {
                return false;
            }
        }

        //get image name from form
        function getImage($name) {
            if(isset($_FILES[$name]["name"]) && $_FILES[$name]["name"] != "") {
                return $_FILES[$name];
            }
            else {
                return false;
            }
        }

        //reset TMP dir
        function delete_files($dir) { 
            foreach(glob($dir . '/*') as $file) { 
            if(is_dir($file)) delete_files($file); else unlink($file); 
            } rmdir($dir);
        }

        function error($msg) {
            echo "<h1 id=red>ERROR: $msg</h1>";

            echo "<div id=errorWarning>
                <div id=errorBanner>
                    <img src=../../img/error.png>
                    <h1>Ein Fehler ist aufgetreten</h1>
                </div>

                <br>
                
                <div id=errorBanner>
                    <p>Fehlermeldung überprüfen und </p>
                    <a href=index.php>Erneut versuchen</a>;
                </div>
            </div>";

            die;
        }


    ?>
    </div>
</body>
</html>
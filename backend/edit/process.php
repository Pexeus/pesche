<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Done!</title>
    <link rel="stylesheet" href="backend.css">
</head>
<body>
    <div class="console">
    <?php
    $path = getPost("path");
    echo "modifiziere: " . $path . "<br><br>";

    $titles = ["imageTitle_1", "imageTitle_2", "imageTitle_3", "imageTitle_4"];
    $toDelete = ["imageDel_1", "imageDel_2", "imageDel_3", "imageDel_4"];
    $images = ["image_1", "image_2", "image_3", "image_4"];

    updateTitle($path, $_POST["titleInput"]);

    for($i = 0; $i < count($images); $i++) {
        $image = getImage($images[$i]);
        $target = $path . "IMG_" . $i;
        $title = getPost($titles[$i]);
        $deletion = getPost($toDelete[$i]);

        if ($deletion == "true") {
            echo "<br>";
            echo "> {$title} wird entfernt... <br>";
            deleteDirectory($target);
        }
        else {
            if ($image != false) {
                if (!file_exists($target . "/")) {
                    mkdir($target);
                }
                replaceImage($target, $image); 
            }
            if (file_exists($target . "/")) {
                updateImageTitle($target, $title);
            }
        }
    }

    function updateTitle($target, $newTitle) {
        $file = $target . "title.txt";
        $currentTitle = fread(fopen($file, "r"), filesize($file));

        if ($currentTitle != $newTitle) {
            file_put_contents($file, $newTitle);
            echo "> Neuer Titel: " . $newTitle . "<br>";
        }
    }

    function updateImageTitle($target, $newTitle) {
        if (file_exists($target)) {
            $dataFile = $target . "/data.txt";

            if (file_exists($dataFile)) {
                $file = fopen($dataFile, "r");
                if (filesize($dataFile) > 0) {
                    $currentTitle = fread($file, filesize($dataFile));
                }
                else {
                    $currentTitle = "";
                }
                fclose($file);

                if ($currentTitle != $newTitle && $newTitle != "") {
                    file_put_contents($dataFile, $newTitle);
                    echo "<br>> Bildüberschrift aktualisiert: [" . $currentTitle . " -> " . $newTitle . "]<br>";
                }
            }
            else {
                $newTitleFile = fopen($target . "/data.txt", "w") or die("Unable to open file!");
                fwrite($newTitleFile, $newTitle);
                fclose($newTitleFile);

                echo "> Neue Bildüberschrift:" . $newTitle . "<br>";
            }
        }
    }

    //replace image in Gallery
    function replaceImage($target, $image) {

        //clearing current images
        $files = glob($target . '/*');
        foreach($files as $file){
            if(is_file($file)){
                if (basename($file) != "data.txt") {
                    unlink($file);
                }
            }
        }

        //inserting new images
        uploadImage($image, $target . "/");
    }

    function uploadImage($image, $target) {
        echo " >starte upload von " . basename($image["name"]) . "... <br>";

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

            echo "> compressing " . $image["name"] . "... <br>";

            compress($targetFile, $targetFileCompressed, 10);

            echo " >" . $image["name"] . " wurde hochgeladen! <br>";
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

    function fileName($originalName) {
        //replace spaces with underscores
        $noSpaces = preg_replace('/\s+/', '_', $originalName);

        $search = array("Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´");
        $replace = array("Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", "");

        $noBullshit = str_replace($search, $replace, $noSpaces);

        return $noBullshit;
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

    function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
    
        if (!is_dir($dir)) {
            return unlink($dir);
        }
    
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
    
        }
    
        return rmdir($dir);
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

    echo "<br><br>> alle modifikationen erfolgreich!"
    ?>
</div>
<div id="finished">
        <img src="../../img/done.png" alt="" srcset="">
    </div>

    <script>
        setTimeout(() => {
            location.href = "../index.php";
        }, 1000);
    </script>
</body>
</html>
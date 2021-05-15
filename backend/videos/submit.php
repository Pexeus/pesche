<?php
echo "uploading video... <br>";

$root = "../../data/videos/";
$video = getFile("video");
$title = getPost("title");
$id = time() . "/";

if ($video != false) {
    upladFile($video, $root . $id, $title);
}

function upladFile($file, $path, $name) {
    $fileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
    $fileTypes = ["mov", "mp4"];
    $fileTypeValid = false;
    $legalFileTypes = "";
    $targetFile = $path . $name . "." . $fileType;

    //filetype check
    for ($i = 0; $i < count($fileTypes); $i++) { 
        if ($fileTypes[$i] == $fileType) {
            $fileTypeValid = true;
        }

        $legalFileTypes .= " " . $fileTypes[$i];
    }

    if ($fileTypeValid == false) {
        error("VideoFormat invalid, zulässige Formate: $legalFileTypes");
    }

    //size
    if ($file["size"] > 10000000) {
        error("Dieses Video ist zu gross!");
    }

    echo "> erstelle ordnerstruktur... <br>";
    mkdir($path);

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        echo "> " . $name . " wurde hochgeladen <br>";
    } else {
        echo "Technischer Fehler beim Upload! <br>";
    }
}

function getPost($name) {
    if (isset($_POST[$name]) && $_POST[$name] != "") {
        return $_POST[$name];
    }
    else {
        return false;
    }
}

function getFile($name) {
    if(isset($_FILES[$name]["name"]) && $_FILES[$name]["name"] != "") {
        return $_FILES[$name];
    }
    else {
        return false;
    }
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

echo "<script>location.href = \"./\"</script>";

?>
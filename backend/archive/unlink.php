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

    if (isset($_POST["del"])) {
        $target = $_POST["del"];

        if (is_dir($target)) {
            deleteDirectory($target);
        }

        rebuild(dirname($target) . "/");

        echo "{$target} wurde gelöscht!";
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


    //get form data
    function getPost($name) {
        if (isset($_POST[$name]) && $_POST[$name] != "") {
            return $_POST[$name];
        }
        else {
            return false;
        }
    }

    function rebuild($folder) {
        echo "<br> <br> rebuilding $folder <br> <br>";

        $entries = scandir($folder);
        $index = 0;

        scatter($folder);

        $entries = scandir($folder);

        foreach ($entries as $entry) {
            if (is_dir($folder . $entry) && $entry != "." && $entry != "..") {
                $index += 1;

                if ($folder . $entry != $folder . $index) {
                    rename($folder . $entry, $folder . $index);
                    echo "> renamed: $entry to $index <br>";
                }
            }
        }
    }

    function scatter($folder) {
        $entries = scandir($folder);

        $index = 0;

        foreach ($entries as $entry) {
            if (is_dir($folder . $entry) && $entry != "." && $entry != "..") {
                $index += 1;

                rename($folder . $entry, $folder . "#" . $index);
            }
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

    echo "<br><br>> alle modifikationen erfolgreich!"
    ?>
</div>
<div id="finished">
        <img src="../../img/done.png" alt="" srcset="">
    </div>

    <script>
        setTimeout(() => {
            location.href = "./index.php";
        }, 1000);
    </script>
</body>
</html>
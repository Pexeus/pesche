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
    <title>[ GEFÄHRLICH ] Backups</title>
    <link rel="stylesheet" href="backups.css">
</head>
<body>
    <h1 class="title">Backups</h1>
    <form action="process.php" method="post" id="backupSelection">
        <input type="hidden" value="false" id="backupName" name="backup">
        <?php
        $backups = "../../backups/";
        displayContents($backups);
        
        function displayContents($target) {
            $files = glob($target . "*");
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION)) {
                    $name = basename($file);

                    preg_match_all('!\d+!', $name, $matches);
                    $date = gmdate("d.m Y", $matches[0][0]);

                    echo "
                    <div class=backup onclick=\"setBackup()\" id=$file>
                        <div class=start>
                            <img src=./zip.png alt=zipfile>
                            <p>{$name}</p>
                        </div>
                        <p>Datum: {$date}</p>
                        <div>
                            <input type=submit name=download value=Download>
                            <input type=submit name=restore value=Wiederherstellen>
                            <input type=submit name=remove value=Löschen>
                        </div>
                    </div>
                    ";
                }
            }
        }
        ?>

        <input type="submit" name="newBackup" value="Neues Backup">
    </form>

    <form enctype="multipart/form-data" action="upload.php" method="POST" id="uploadForm">
        <h1>Backup hochladen</h1>

        <!-- MAX_FILE_SIZE muss vor dem Dateiupload Input Feld stehen -->
        <input type="hidden" name="MAX_FILE_SIZE" value="300000000000000" />
        <!-- Der Name des Input Felds bestimmt den Namen im $_FILES Array -->
        <input name="userfile" type="file" />
        <input type="submit" id="submitUpload" value="Upload" />
    </form>

    <script src="./form.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[ GEFÄHRLICH ] Datenimport</title>
    <link rel="stylesheet" href="import.css">
</head>
<body>
    <h1>Import auswählen</h1>
    <form action="import.php" method="post">
        <?php
        $external = "../../../";
        displayContents($external);
        
        function displayContents($target) {
            $files = glob($target . "*", GLOB_ONLYDIR);

            foreach ($files as $file) {
                $name = basename($file);

                echo "
                    <div class=file onclick=\"setImport()\" id=$file>
                        <img src=folder.png alt=folder>  
                        <h3>$name</h3>
                    </div>
                ";
            }
        }
        ?>

        <input type="hidden", value="false" id="importPath" name="path">
        <h2 id="displayPath"></h2>
        <input type="submit" value="Importieren" id="submitButton">
    </form>
    
    <script src="form.js"></script>
</body>
</html>
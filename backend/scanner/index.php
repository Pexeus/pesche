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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="head">
            <a href="../"><h1 id="exit"><</h1></a>
            <h1 id="title">Rohdaten</h1>
    </div>
    <table id="entries">
    <tr>
        <th>Titel</th>
        <th>Pfad</th>
        <th>Inhalte</th>
        <th>Anzahl inhalte</th>
    </tr>

    <?php
        $root = "../../data/book/";

        function scanDatasets($root) {
            $cats = glob($root . '*');

            foreach ($cats as $cat) {
                $posts = glob($cat . '/*');
            
                foreach ($posts as $post) {
                    $posts = glob($cat . '/*');
                    
                    $imageDirs = glob($post . "/*", GLOB_ONLYDIR);
                    
                    foreach ($imageDirs as $imageDir) {
                        
                        if (file_exists($imageDir . "/data.txt")) {
                            $title = file_get_contents($imageDir . "/data.txt");

                            if ($title == "") {
                                $title = "Kein Titel";
                            }
                        }
                        else {
                            $title = "Error: Datei fehlt!";
                        }

                        $images = glob($imageDir . "/*");
                        $nrContents = 0;
                        $contents = "";
                        $imageLink = "";

            
                        foreach ($images as $image) {
                            $nrContents += 1;
                            $contents .= basename($image) . ", ";

                            if (basename($image) != "compressed.jpeg" && basename($image) != "data.txt") {
                                $imageLink = "<a target=\"_blank\" href=\"$image\">Prüfen</a>";
                            }
                        }
            
                        echo "
                        <tr>
                            <td>$title</td>
                            <td>$imageDir</td>
                            <td>$contents $imageLink</td>
                            <td>$nrContents</td>
                        </tr>
                        ";
                    }
                }
            }
        }

        scanDatasets($root);
    ?>
</table>

<div id="search">
    <input type="text" placeholder="Suche..." oninput="search()" id="searchInput">
</div>

<script src="./script.js"></script>

</body>
</html>
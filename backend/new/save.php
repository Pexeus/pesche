<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="backend.css">
</head>
<body>
    <div class="console">
        <?php
            //getting form data
            $category = $_POST["category"];
            echo("wird veröffentlicht in: " . $category . "<br><br>");

            //source
            publish("../../data/temp/", $category);




            function publish($src, $category) {
                $saveDir = "../../data/book/" . $category . "/";

                $entries = scandir($saveDir);
                $ID = 1;

                foreach ($entries as $entry) {
                    if (is_dir($saveDir . $entry) && $entry != "." && $entry != "..") {
                        $ID += 1;
                    }
                }

                echo("> Einträge in Kategorie: " . ($ID + 1) . "<br>");
                echo("<br> <p id=green>> Vorgang abgeschlossen - kehre zur startseite zurück.</p>");
                
                $target = $saveDir . $ID;

                mkdir($target);

                cpy($src, $target);
            }

            function cpy($source, $dest){
                if(is_dir($source)) {
                    $dir_handle=opendir($source);
                    while($file=readdir($dir_handle)){
                        if($file!="." && $file!=".."){
                            if(is_dir($source."/".$file)){
                                if(!is_dir($dest."/".$file)){
                                    mkdir($dest."/".$file);
                                }
                                cpy($source."/".$file, $dest."/".$file);
                            } else {
                                copy($source."/".$file, $dest."/".$file);
                            }
                        }
                    }
                    closedir($dir_handle);
                } else {
                    copy($source, $dest);
                }
            }
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
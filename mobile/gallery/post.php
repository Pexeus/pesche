<?php
    $path = $_GET["path"];

    insertContent($path . "/");

    function insertContent($postRoot) {
        foreach(glob($postRoot . "*", GLOB_ONLYDIR) as $imageContainer) {
            $contents = array_filter(glob($imageContainer . "/*"), 'is_file');

            foreach ($contents as $content) {
                if (basename($content) != "compressed.jpeg" && basename($content) != "data.txt") {
                    $image = $content;
                    $title = file_get_contents($imageContainer . "/data.txt");

                    echo "
                    <div id=imageContainer>
                        <img src={$image} alt={$title}>
                        <h1>{$title}</h1>
                    </div>
                    ";
                }
            }
        }
    }
?>
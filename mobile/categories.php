<a href=""></a>

<?php

function init() {
    $root = "../data/book/";

    foreach(glob($root . "*", GLOB_ONLYDIR) as $category) {
        $name = basename($category);

        echo "
        <a href=./browse/?category={$name}
            <div id=categorySelector>
                <img src=" . categoryPreview($category) . ">
                <h1>{$name}</h1>
            </div>
        </a>";
    }
}

function categoryPreview($category) {
    $target = $category . "/1/";

    if (file_exists($target)) {
        foreach(glob($target . "*", GLOB_ONLYDIR) as $folder) {
            $contents = scandir($folder);

            foreach ($contents as $content) {
                if ($content != "." && $content != ".." && $content != "compressed.jpeg" && $content != "data.txt") {
                    $src = $folder . "/" . $content;

                    return $src;
                }
            }
        }
    }

    //Hier plazhalter
    return "JOBUNGA";
}

init()
?>
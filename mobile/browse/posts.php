<?php

function displayPosts() {
    $root = "../../data/book/";
    $category = $_GET["category"];

    $path = $root . $category . "/";

    foreach(glob($path . "*", GLOB_ONLYDIR) as $post) {

        $title = getTitle($post);
        $preview = postPreview($post);

        echo "
        <a href=../gallery/?path={$post}
            <div id=postSelector>
                <img src={$preview}>
                <h1>{$title}</h1>
            </div>
        </a>";
    } 
}

function postPreview($target) {
    if (file_exists($target)) {

        foreach(glob($target . "/*", GLOB_ONLYDIR) as $folder) {
            $contents = scandir($folder);

            foreach ($contents as $content) {
                if ($content == "compressed.jpeg") {
                    $src = $folder . "/" . $content;

                    return $src;
                }
            }
        }
    }

    //Hier plazhalter
    return "JOBUNGA";
}

function getTitle($path) {
    $filePath = $path . "/title.txt";
    $title = file_get_contents($filePath);

    return $title;
}

displayPosts()
?>
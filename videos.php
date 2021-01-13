<?php
function init($root) {
    echo "<div id=Videos>";
    insertVideos($root);
    echo "</div>";
}

function insertVideos($root) {
    $videosShit = scandir($root);
    $videos = array_values(array_diff($videosShit, array('.', '..')));

    if (count($videos) %2 != 0) {
        array_push($videos, "empty");
    }

    for($i = 0; $i < count($videos); $i++) {
        if ($i %2 != 0) {
            $video1 = $videos[$i - 1];
            $video2 = $videos[$i];
        
            echo "<div id=page>";
            echo "<div id=left>";
                echo "<div id=pageContent>";
                    echo vGen($root, $video1);
                    //var_dump(vGen($root, $video1));
                echo "</div>";
            echo "</div>";
            echo "<div id=right>";
                echo "<div id=pageContent>";
                    echo vGen($root, $video2);
                    //var_dump(vGen($root, $video2));
                echo "</div>";
            echo "</div>";
        echo "</div>";
        }
    }
}

function vGen($root, $id) {
    if ($id != "empty") {
        $path = $root . $id . "/";
        $contents = scandir($path);

        $vSource = $path . $contents[2];

        $splitter =  pathinfo($vSource);
        $title = explode("." . $splitter["extension"], $contents[2])[0];

        $html = "
        <div class=video>
            <video src=\"$vSource\" onclick=\"playVideo()\"></video>
            <h1>$title</h1>
        </div>";

        return $html;
    }
    else {
        return "";
    }
}

init("./data/videos/");
?>
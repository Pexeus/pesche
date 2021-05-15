<div class="vDashboard">
    <?php
        $root = "../../data/videos/";
        
        function displayVideos($root) {
            $videoSets = scandir($root);

            foreach($videoSets as $vSet) {
                if (is_dir($root . $vSet) && $vSet != "." && $vSet != "..") {
                    echo "<div class=vBox>";
                    $contents = scandir($root . $vSet);
                    foreach($contents as $content) {
                        if ($content != "." && $content != "..") {
                            $vSource = $root . $vSet . "/" . $content;
                            echo "<video src=\"$vSource\"></video>";
                            echo "<p>$content</p>";
                            echo "<a href=./del.php?file=$vSet><img src=./img/trash.png alt=delete class=delete></a>";
                        }
                    }
                    echo "</div>";
                }
            }
        }

        displayVideos($root)
    ?>
</div>
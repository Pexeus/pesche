<div class="displayDataMain">
    <?php
        $root = "../../data/archive";
        
        foreach(glob($root . "/*", GLOB_ONLYDIR) as $post) {
            insertEntry($post . "/");
        }

        function insertEntry($path) {
            $imagePath = getImage($path);
            $title = getTitle($path);
            $imageCount = countImages($path);

            echo "<div class=entry>";
            
                echo "<div class=entryHead>";
                    echo "<h1>$title</h1>";
                    echo "<img src=$imagePath>";
                echo "</div>";

                echo "<div class=entryBody>";
                    echo "<h1>$imageCount</h1>";
                    echo "<p>Bilder</p>";

                    echo "<br>";

                    echo "
                    <div class=entryForm>
                        <form action=unlink.php method=post>
                            <input type=hidden name=del value=$path>
                            <input type=submit value=Löschen id=deleteButton>
                        </form>
                        <form action=restore.php method=post>
                            <input type=hidden name=restore value=$path>
                            <input type=submit value=Veröffentlichen id=deleteButton>
                        </form>
                    </div>";

                echo "</div>";

            echo "</div>";
        }

        function countImages($path) {
            $contents = scandir($path);
            $images = 0;

            foreach ($contents as $content) {
                if (is_dir($path . $content) && $content != "." && $content != "..") {
                    $images += 1;
                }
            }

            return $images;
        }

        function getTitle($path) {
            $filePath = $path . "title.txt";
            $title = file_get_contents($filePath);

            return $title;
        }

        function getImage($path) {
            $contents = scandir($path);

            foreach ($contents as $content) {
                if (is_dir($path . $content) && $content != "." && $content != "..") {
                    return $path . $content . "/compressed.jpeg";
                }
            }

            return "../img/placeholder.png";
        }
    ?>
</div>
<div class="displayDataMain">
    <?php
        $root = "../data/book/";
        
        function displayData($root) {
            $categories = scandir($root);

            foreach ($categories as $category) {
                if (is_dir($root . $category) && $category != "." && $category != "..") {
                    echo "<div class=category>
                        <div class=categoryHead onclick=toggleCategory()>
                            <h1>$category</h1>
                        </div>";

                        insertEntries($root, $category);

                    echo "</div>";
                }
            }
        }

        function insertEntries($root, $category) {

            $path = $root . $category . "/";

            $entries = scandir($root . $category);

            foreach ($entries as $entry) {
                if (is_dir($path . $entry) && $entry != "." && $entry != "..") {
                    insertEntry($entry, $path . $entry . "/");
                }
            }
        }

        function insertEntry($entry, $path) {
            //echo $path;

            $imagePath = getImage($path);
            $title = getTitle($path);
            $imageCount = countImages($path);

            $toggleFav = getFavToggler($path);

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
                        <form action=process.php method=post>
                            <input type=hidden name=del value=$path>
                            <input type=submit value=Archivieren id=deleteButton>
                        </form>
                        <form action=./edit/index.php method=post id=excludeLoader>
                            <input type=hidden name=edit value=$path>
                            <input type=submit value=Bearbeiten id=editButton>
                        </form>
                        {$toggleFav}
                    </div>";

                echo "</div>";

            echo "</div>";
        }

        function getFavToggler($path) {
            $favFile = $path . "fav.txt";

            if (file_exists($favFile)) {
                return "
                    <form action=./fav.php method=post id=excludeLoader>
                        <input type=hidden name=unFav value=$path>
                        <button id=unFavButton type=submit><img src=../img/favorite.png alt=favorite></button>
                    </form>
                ";
            }
            else {
                return "
                    <form action=./fav.php method=post id=excludeLoader>
                        <input type=hidden name=fav value=$path>
                        <button id=setFavButton type=submit><img src=../img/favorite.png alt=favorite></button>
                    </form>
                ";
            }
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

        displayData($root);
    ?>
</div>
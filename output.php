<?php
    function outputCategories() {
        $rootDir = "./data/book/";

        $categories = scandir($rootDir);

        foreach ($categories as $category) {
            if (is_dir($rootDir . $category) && $category != "." && $category != "..") {
                echo "<div id=$category>";
                    insertPages($rootDir . $category . "/");
                echo "</div>";
            }
        }
    }

    function insertPages($dir) {
        $pages = scandir($dir);

        foreach ($pages as $page) {
            if (is_dir($dir . $page) && $page != "." && $page != "..") {
                if (file_exists($dir. $page . "/fav.txt")) {
                    echo "<div id=page class=fav>";
                    insertContent($dir, $page);
                    echo "</div>";
                }
                else {
                    echo "<div id=page>";
                    insertContent($dir, $page);
                    echo "</div>";
                }
            }
        }
    }

    function insertContent($dir, $page) {
        $postRoot = $dir . $page . "/";
        $contents = scandir($postRoot);



        $images = [];

        foreach ($contents as $content) {
            if (is_dir($postRoot . $content) && $content != "." && $content != "..") {
                array_push($images, $content . "/");
            }
        }

        if (count($images) == 1) {
            echo "<div id=left>";
                echo "<div id=pageContent>";
                    echo insertImage($postRoot, $images[0], "large");
                echo "</div>";
            echo "</div>";

            echo "<div id=right>";
            echo "<div id=pageContent>";
                    
                echo "</div>";
            echo "</div>";
        }

        if (count($images) == 2) {
            echo "<div id=left>";
                echo "<div id=pageContent>";
                    echo insertImage($postRoot, $images[0], "large");
                echo "</div>";
            echo "</div>";

            echo "<div id=right>";
            echo "<div id=pageContent>";
                    echo insertImage($postRoot, $images[1], "large");
                echo "</div>";
            echo "</div>";
        }

        if (count($images) == 3) {
            echo "<div id=left>";
                echo "<div id=pageContent>";
                    echo insertImage($postRoot, $images[0], "normal");
                    echo insertImage($postRoot, $images[1], "normal");
                echo "</div>";
            echo "</div>";

            echo "<div id=right>";
            echo "<div id=pageContent>";
                    echo insertImage($postRoot, $images[2], "large");
                echo "</div>";
            echo "</div>";
        }

        if (count($images) == 4) {
            echo "<div id=left>";
                echo "<div id=pageContent>";
                    echo insertImage($postRoot, $images[0], "normal");
                    echo insertImage($postRoot, $images[1], "normal");
                echo "</div>";
            echo "</div>";

            echo "<div id=right>";
            echo "<div id=pageContent>";
                echo insertImage($postRoot, $images[2], "normal");
                echo insertImage($postRoot, $images[3], "normal");
                echo "</div>";
            echo "</div>";
        }
    }

    function insertImage($root, $src, $type) {
        $contents = scandir($root . $src);
        $path = $root . $src;

        
		if (file_exists($path . "data.txt")) {
            $title = file_get_contents($path . "data.txt");
        }
        else {
            $title = "";
        }

        foreach ($contents as $content) {
            if ($content != "." && $content != ".." && $content == "compressed.jpeg") {
                return "

                <div id=$type>
                    <form action=maxRes.php target=_blank method=post class=openImageForm>
                        <input type=hidden value=$path name=imagePath>
                        <img src=\"$path$content\" alt=\"\">
                        <h1>$title</h1>
                    </form>
                </div>

                ";
            }
        }

        return "<img src=\"./img/error.png\" alt=<\"\">";
    }



    function out() {
        outputCategories();
    }

    out();
?>
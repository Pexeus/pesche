<?php
            if (isset($_POST["del"])) {
                deleteEntry($_POST["del"]);
                echo "<script>location.href = \"./index.php\"</script>";
            }

            if (isset($_POST["command"])) {
                if ($_POST["command"] == "rebuild") {
                    fullRebuild();
					echo "<script>location.href = \"./index.php\"</script>";
                }
                if ($_POST["command"] == "new") {
                    echo "<script>location.href = \"./new/\"</script>";
                }
                if ($_POST["command"] == "home") {
                    echo "<script>location.href = \"../\"</script>";
                }
                if ($_POST["command"] == "archive") {
                    echo "<script>location.href = \"./archive\"</script>";
                }
                if ($_POST["command"] == "import") {
                    echo "<script>location.href = \"./import\"</script>";
                }
                if ($_POST["command"] == "backups") {
                    echo "<script>location.href = \"./backups\"</script>";
                }
                if ($_POST["command"] == "videos") {
                    echo "<script>location.href = \"./videos\"</script>";
                }
                if ($_POST["command"] == "scan") {
                    echo "<script>location.href = \"./scanner\"</script>";
                }
            }


            function fullRebuild() {
                $dir = "../data/book/";

                fixDatasets($dir);

                $entries = scandir($dir);
                foreach ($entries as $entry) {
                    if (is_dir($dir . $entry) && $entry != "." && $entry != "..") {
                        rebuild($dir . $entry . "/");
                    }
                }
            }

            function deleteEntry($toDelete) {
                echo "removing $toDelete <br>";

                $archive = "../data/archive/";
                $index = getArchiveIndex();

                rename($toDelete, $archive . $index);
                
				rebuild(dirname($toDelete) . "/");
            }

            function getArchiveIndex() {
                $archive = "../data/archive/";
                $index = 0;

                $entries = scandir($archive);

                foreach ($entries as $entry) {
                    if (is_dir($archive . $entry) && $entry != "." && $entry != "..") {
                        $index += 1;
                    }
                }

                return $index + 1;
            }

            function rebuild($folder) {
                echo "<br> <br> rebuilding $folder <br> <br>";

                $entries = scandir($folder);
                $index = 0;

                scatter($folder);

                $entries = scandir($folder);

                foreach ($entries as $entry) {
                    if (is_dir($folder . $entry) && $entry != "." && $entry != "..") {
                        $index += 1;

                        if ($folder . $entry != $folder . $index) {
                            rename($folder . $entry, $folder . $index);
                            echo "> renamed: $entry to $index <br>";
                        }
                    }
                }
            }

            function scatter($folder) {
                $entries = scandir($folder);

                $index = 0;

                foreach ($entries as $entry) {
                    if (is_dir($folder . $entry) && $entry != "." && $entry != "..") {
                        $index += 1;

                        rename($folder . $entry, $folder . "#" . $index);
                    }
                }
            }

            function fixDatasets($root) {
                $cats = glob($root . '*');
            
            
                foreach ($cats as $cat) {
                    echo "<br><br>-----------" . $cat . "-----------<br><br>";
                    $posts = glob($cat . '/*');
                
                    foreach ($posts as $post) {
                        $posts = glob($cat . '/*');
                        
                        $imageDirs = glob($post . "/*", GLOB_ONLYDIR);
                        
                        foreach ($imageDirs as $imageDir) {
                            $images = glob($imageDir . "/*");
                            $nrContents = 0;
                
                            foreach ($images as $image) {
                                if (basename($image) != "data.txt") {
                                    $nrContents += 1;
                                }
                            }
                
                            if ($nrContents > 2) {
                                $keepMe = $images[0];
                                foreach ($images as $image) {
                                    if ($image != $keepMe) {
                                        unlink($image);
                                    }
                                }
                
                                compress($keepMe, $imageDir . "/compressed.jpeg", 10);
                                echo "rebuilt " . $imageDir . " width " . $keepMe . "<br>";
                            }
                        }
                    }
                }
            
                echo "<br><br>Starting check... <br><br>";
                foreach ($cats as $cat) {
                    $posts = glob($cat . '/*');
                
                    foreach ($posts as $post) {
                        $posts = glob($cat . '/*');
                        
                        $imageDirs = glob($post . "/*", GLOB_ONLYDIR);
                        
                        foreach ($imageDirs as $imageDir) {
                            $images = glob($imageDir . "/*");
                            $nrContents = 0;
                
                            foreach ($images as $image) {
                                if (basename($image) != "data.txt") {
                                    $nrContents += 1;
                                }
                            }
                
                            echo $nrContents . "<br>";
                        }
                    }
                }
            }
            
            function compress($source, $destination, $quality) {
            
                $exif = exif_read_data($source);
                $orientation = $exif['Orientation'];
            
                $info = getimagesize($source);
            
                if ($info['mime'] == 'image/jpeg') {
                    $image = imagecreatefromjpeg($source);
                }
            
                elseif ($info['mime'] == 'image/gif') {
                    $image = imagecreatefromgif($source);
                }
            
                elseif ($info['mime'] == 'image/png') {
                    $image = imagecreatefrompng($source);
                }
            
                switch ($orientation) {
                    case 2:
                        imageflip($image, IMG_FLIP_HORIZONTAL);
                        break;
                    case 3:
                        $image = imagerotate($image, 180, 0);
                        break;
                    case 4:
                        imageflip($image, IMG_FLIP_VERTICAL);
                        break;
                    case 5:
                        $image = imagerotate($image, -90, 0);
                        imageflip($image, IMG_FLIP_HORIZONTAL);
                        break;
                    case 6:
                        $image = imagerotate($image, -90, 0);
                        break;
                    case 7:
                        $image = imagerotate($image, 90, 0);
                        imageflip($image, IMG_FLIP_HORIZONTAL);
                        break;
                    case 8:
                        $image = imagerotate($image, 90, 0); 
                        break;
                }
            
                imagejpeg($image, $destination, $quality);
            
                return $destination;
            }

            echo "<p id=green>Fehlerfreie Abfrage</p>";
        ?>
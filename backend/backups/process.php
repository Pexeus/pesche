<?php
    print_r($_POST);

    if (isset($_POST["download"])) {
        $file_url = $_POST["backup"];

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
        
        readfile($file_url); 
        exit();
    }

    if (isset($_POST["restore"])) {
        backupData();
        echo "restoring...";

        $path = $_POST["backup"];

        header("Location: ./restore.php/?path=$path");
    }

    if (isset($_POST["remove"])) {
        unlink($_POST["backup"]);

        echo "<br><br>Backup gelöscht!";
    }
    
    if (isset($_POST["newBackup"])) {
        backupData();
    }

    function backupData() {
        $target = "../../data/";
        if (file_exists($target) && is_dir($target)) {
            echo "creating backup...<br>";
    
            $backupLocation = "../../backups/";
            $date = new DateTime();
            $timestamp = $date->getTimestamp();
    
            $backupPath = "{$backupLocation}backup_{$timestamp}";

            copy_r($target, $backupPath);
    
            echo "compressing backup: {$backupPath} <br>";
            compress($backupPath, $backupPath . ".zip");
    
            if (file_exists($backupPath . ".zip")) {
                deleteDirectory($backupPath);
            }

            echo "backup completed! <br>";
        }
        else {
            mkdir("../../data/");
        }
    }

    function copy_r($from, $to) {
        global $skip;
        $dir = opendir($from);
        if (!file_exists($to)) {mkdir ($to, 0775, true);}
        while (false !== ($file = readdir($dir))) {
            if ($file == '.' OR $file == '..') {continue;}
            
            if (is_dir($from . DIRECTORY_SEPARATOR . $file)) {
                copy_r($from . DIRECTORY_SEPARATOR . $file, $to . DIRECTORY_SEPARATOR . $file);
            }
            else {
                copy($from . DIRECTORY_SEPARATOR . $file, $to . DIRECTORY_SEPARATOR . $file);
            }
        }
        closedir($dir);
    }
    
    function compress($main_path, $zip_file) {
        if (file_exists($main_path) && is_dir($main_path))  
        {
            $zip = new ZipArchive();
    
            if (file_exists($zip_file)) {
                unlink($zip_file); // truncate ZIP
            }
            if ($zip->open($zip_file, ZIPARCHIVE::CREATE)!==TRUE) {
                die("cannot open <$zip_file>\n");
            }
    
            $files = 0;
            $paths = array($main_path);
            echo "<br><br>";
            print_r($paths);
            echo "<br><br>";
            while (list(, $path) = each($paths))
            {
                foreach (glob($path.'/*') as $p)
                {
                    if (is_dir($p)) {
                        $paths[] = $p;
                    } else {
                        $zip->addFile($p);
                        $files++;
                    }
                }
            }
    
            echo 'Total files: '.$files . "<br>";
    
            $zip->close();
        }
    }
    
    function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
    
        if (!is_dir($dir)) {
            return unlink($dir);
        }
    
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
    
        }
    
        return rmdir($dir);
    }

    echo "<script>location.href = \"./\"</script>";
?>
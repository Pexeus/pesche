<?php
$import = $_POST["path"];

if ($import != "false") {
    importData($import);
}

function importData($import) {
    $root = "../../data";

    backupData();

    mkdir($root);

    echo "starting import...";
    copy_r($import, $root);

    echo "done!";
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

function backupData() {
    $target = "../../data/";
    if (file_exists($target) && is_dir($target)) {
        echo "creating backup...<br>";

        $backupLocation = "../../backups/";
        $date = new DateTime();
        $timestamp = $date->getTimestamp();

        $backupPath = "{$backupLocation}backup_{$timestamp}";

        rename($target, $backupPath . "/");

        echo "compressing backup... <br>";
        compress($backupPath);

        if (file_exists($backupPath . ".zip")) {
            deleteDirectory($backupPath);
        }

        echo "backup completed! <br>";
    }
}

function compress($main_path) {
    $zip_file = $main_path . ".zip";

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
        while (list(, $path) = each($paths))
        {
            foreach (glob($path.'/*') as $p)
            {
                if (is_dir($p)) {
                    $paths[] = $p;
                } else {
                    $zip->addFile($p);
                    $files++;

                    echo $p."<br>\n";
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
?>
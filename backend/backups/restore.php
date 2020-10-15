<?php
$backup = $_GET["path"];

restoreBackup($backup);

function restoreBackup($path) {

    if (file_exists('../../import/backups')) {
        deleteDirectory('../../import/backups');
    }

    if (file_exists("../../data/")) {
        deleteDirectory('../../data/');
    }

    $zip = new ZipArchive;
    if ($zip->open($path) === TRUE) {
        $zip->extractTo('../../import');
        $zip->close();
        
        $pathBase = basename(preg_replace('/\\.[^.\\s]{3,4}$/', '', $path));

        rename("../../import/backups/{$pathBase}/", "../../data/");

    } else {
        echo 'Fehler beim entpacken';
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

echo "<script>location.href = \"../\"</script>";
?>
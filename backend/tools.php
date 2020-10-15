<?php
$ru = $_SERVER["REQUEST_URI"];
if (strpos($ru, 'tools.php') !== false) {
    if((strpos($ru, 'tools.php/') !== false)){
        header("Location: ../../signin/index.php?error=accessDenied");
        exit();
    }
    else{
        header("Location: ../signin/index.php?error=accessDenied");
        exit();
    }
}
?>

<h2>Übersicht</h2>
<p>Rebuild: Baut die Datenstruktur neu auf.</p>
<p>Hochladen: Hier können Einträge hinzugefügt werden.</p>
<p>Archiv: Archivierte einträge wiederherstellen/löschen.</p>
<p>Backups: Backups erstellen/exportieren.</p>


<?php
    function insertTools() {
        $commands = ["rebuild", "new", "archive", "backups", "home"];
        $text = ["Rebuild", "Hochladen", "Archiv", "Backups", "Startseite"];

        for ($i = 0; $i < count($commands); $i++) {
            tool($commands[$i], $text[$i]);
        }
    }

    function tool($command, $text) {
        echo "
            <form class=toolForm action=process.php method=post>
                <input type=hidden name=command value=$command>
                <input type=submit value=$text />
            </form>
        ";
    }

    function displayCapacity() {
        $folders = ["../data/book", "../data/archive", "../backups"];
        $names = ["Aktive Einträge", "Archiv", "Backups"];

        for ($i = 0; $i < count($folders); $i++) {
            $name = $names[$i];
            $size = formatBytes(GetDirectorySize($folders[$i]));

            echo "
                <div id=displaySize>
                    <h3>{$name}</h3>
                    <h2>{$size}</h2>
                </div>    
            ";
        }
    }

    function GetDirectorySize($path){
        $bytestotal = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                $bytestotal += $object->getSize();
            }
        }
        return $bytestotal;
    }

    function formatBytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    insertTools();
    displayCapacity();
?>
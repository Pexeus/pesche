<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  text-align: center;
}
</style>

<table style="width:100%">
  <tr>
    <th>Titel</th>
    <th>Pfad</th>
    <th>Inhalte</th>
    <th>Anzahl inhalte</th>
  </tr>

<?php
$root = "../data/book/";

function scanDatasets($root) {
    $cats = glob($root . '*');

    foreach ($cats as $cat) {
        $posts = glob($cat . '/*');
    
        foreach ($posts as $post) {
            $posts = glob($cat . '/*');
            
            $imageDirs = glob($post . "/*", GLOB_ONLYDIR);
            
            foreach ($imageDirs as $imageDir) {
                
                if (file_exists($imageDir . "/data.txt")) {
                    $title = file_get_contents($imageDir . "/data.txt");
                }
                else {
                    $title = "";
                }

                $images = glob($imageDir . "/*");
                $nrContents = 0;
                $contents = "";

    
                foreach ($images as $image) {
                    $nrContents += 1;
                    $contents .= basename($image) . ", ";
                }
    
                echo "
                <tr>
                    <td>$title</td>
                    <td>$imageDir</td>
                    <td>$contents</td>
                    <td>$nrContents</td>
                </tr>
                ";
            }
        }
    }
}

scanDatasets($root);
?>

</table>
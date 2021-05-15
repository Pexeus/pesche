<?php
$root = "../../data/videos/";
$toDel = $_GET["file"];

deleteVideo($root, $toDel);
echo "<script>location.href = \"./\"</script>";

function deleteVideo($root, $id) {
    $path = $root . $id;
    echo "deleting $path";
    
    recurseRmdir($path);
}

function recurseRmdir($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  }
?>
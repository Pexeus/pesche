<?php
    if (isset($_POST["fav"])) {
        echo "fav" . $_POST["fav"];

        $path = $_POST["fav"];

        $favFile = fopen($path . "fav.txt", "w") or die("Fehler beim abspeichern: [PHP, fopen]");
        fwrite($favFile, "favorite");
        fclose($favFile);
    }

    if (isset($_POST["unFav"])) {
        echo "unFav";

        $path = $_POST["unFav"];

        unlink($path . "fav.txt");
    }
?>

<script>
    location.href = "./index.php";
</script>
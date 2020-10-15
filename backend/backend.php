<?php
$ru = $_SERVER["REQUEST_URI"];
if (strpos($ru, 'backend.php') !== false) {
    if((strpos($ru, 'backend.php/') !== false)){
        header("Location: ../../signin/index.php?error=accessDenied");
        exit();
    }
    else{
        header("Location: ../signin/index.php?error=accessDenied");
        exit();
    }
}
else
?>
    <div class="tools">
        <div class="panel">
            <div class="panelHead">
                <h1>Tools</h1>
                <form action="../signin/scripts/signout-script.php" method="POST">
                    <input id="signout" type="submit" name="b-signout" value="Abmelden">
                </form>
            </div>
            <?php
                require("tools.php");
            ?>
        </div>
    </div>

    <div class="mainMenu">
        <?php
            require("displayData.php")
        ?>
    </div>

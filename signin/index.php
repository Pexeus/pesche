<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="./signin.css">
</head>
<body>
    <?php
        require("./scripts/error-handler.php");
    ?>
    <div id="content">
        <div id="login">
            <h2>Sign in</h2>
            <form action="./scripts/signin-script.php" method="POST">           
                <?php
                    if(isset($_GET["uid"])){
                        echo "<input type=\"text\" class=\"i\" id=\"i-uname\" name=\"uid\" placeholder=\"username..\" value=\"".$_GET["uid"]."\">";
                    }
                    else{
                        echo "<input type=\"text\" class=\"i\" id=\"i-uname\" name=\"uid\" placeholder=\"username..\">";
                    }
                ?>
                <input type="password" class="i" id="i-pwd" name="pwd" placeholder="password..">
                <button id="submit" type="submit" name="signin-submit">Submit</button>
            </form>
        </div>
    </div>
    <script src="../js/signin.js"></script>
</body>
</html>
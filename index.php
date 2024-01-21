
<script>
    if (screen.width <= 699) {
        document.location = "./mobile/";
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <title>Peter Zaugg</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="welcome">
        <h1>Bleistiftzeichnungen von Peter Zaugg</h1>
        <img src="./img/loading.svg">
    </div>
    <div id="books">
    <div id="portrait">
        <img src="./img/portrait.jpg" alt="">
    </div>

        <div id="book">
            <div id="cover">
                <h1>Willkommen</h1>
                <br>
                <h3>bei den</h3>
                <h3>Bleistift und Acrylzeichnungen</h3>
                <h3>von</h3>
                <br>
                <h2>Peter Zaugg</h2>
            </div>

            <div id="content">
                <div id="bookInside">
                    
                </div>
                <?php
                    require("output.php");
                    require("videos.php");
                ?>
            </div>


            <div id="bookmarks">

            </div>
			<!--
			<div class="tutorial">
				<div class="left">
					<h2>Hier klicken um zurück zu blättern</h2>
				</div>
				<div class="right">
					<h2>Hier klicken um weiter zu blättern</h2>
				</div>
				<div class="image"></div>
			</div>
			-->
        </div>
        </div>
    </div>
    <a href="./contact/">
        <div class="linkContact">
            <img src="./img/letter.png" alt="">
            <p>Kontaktieren Sie mich!</p>
        </div>
    </a>
	
    <div class="linkTR">
        <a href="backend"><img src="./img/user.png" alt=""></a>
    </div>
    <div class="linkTR" id="link2">
        <a href="https://www.flaticon.com/"><img src="./img/flaticon.png" alt=""></a>
    </div>


    <script src="UI.js"></script>
    <script src="book.js"></script>
    <script src="videos.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Uploader</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <div class=uploadContainer>
            <div class=uploadMenu>
                <form action="submit.php" method="post" enctype="multipart/form-data">
                    <div class=preview>
                        <video id="preview_video" autoplay loop muted></video>
                    </div>
                    <div class=interface>
                        <input type="file" required name="video" id="videoInput" onchange="loadFile(event)">
                        <input type="text" required class=titleInput name="title" placeholder="Titel">
                        <div id="upload">
                            <input type="submit" value="Hochladen" name="submit" class=uploadConfirm>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="./previews.js"></script>
    </body>
    </html>
</body>
</html>
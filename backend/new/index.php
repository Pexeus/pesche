<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="backend.css">
    <title>Backend</title>
</head>
<body>
    <div id="UploadSelection">
    <form action="submit.php" method="post" enctype="multipart/form-data">
        <div id="book">
            <div id="left">
                
                <div id="titleSelection">
                    <input type="text" placeholder="Titel" name="titleInput" required>
                </div>

                <div id="image1" class="imageSelector">
                    <div id="imageTitle">
                        <input type="text" placeholder="Bildüberschrift" name="imageTitle_1">
                    </div>

                    <img src="../../img/placeholder.png" alt="" id="preview_image_1">
                    <input type="file" name="image_1" id="imageInput" onchange="loadFile(event)">
                </div>

                <div id="image2" class="imageSelector">
                    <div id="imageTitle">
                        <input type="text" placeholder="Bildüberschrift" name="imageTitle_2">
                    </div>

                    <img src="../../img/placeholder.png" alt="" id="preview_image_2">
                    <input type="file" name="image_2" id="imageInput" onchange="loadFile(event)">
                </div>
            </div>

            <div id="right">

                <div id="void63"></div>

                <div id="image3" class="imageSelector">
                        <div id="imageTitle">
                            <input type="text" placeholder="Bildüberschrift" name="imageTitle_3">
                        </div>

                        <img src="../../img/placeholder.png" alt="" id="preview_image_3">
                        <input type="file" name="image_3" id="imageInput" onchange="loadFile(event)">
                    </div>

                    <div id="image4" class="imageSelector">
                        <div id="imageTitle">
                            <input type="text" placeholder="Bildüberschrift" name="imageTitle_4">
                        </div>

                        <img src="../../img/placeholder.png" alt="" id="preview_image_4">
                        <input type="file" name="image_4" id="imageInput" onchange="loadFile(event)">
                    </div>
                </div>
        </div>


        <div id="upload">
            <input type="submit" value="Weiter" name="submit">
        </div>
    </form>
    </div>
    <script src="./previews.js"></script>
</body>
</html>
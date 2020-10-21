<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktaufnahme</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="formBox">
        <h1>Kontaktaufnahme</h1>
        <form action="./mailer.php" method="post">
            <input type="text" placeholder="Name" name="name" required>
            <br>
            <input type="text" placeholder="Email" name="email" required>
            <br>
            <input type="text" placeholder="Betreff" name="subject" required>
            <br>
            <textarea required name="message" cols="30" rows="10" placeholder="Nachricht"></textarea>
            <br>
            <input type="submit" name="send" value="Absenden" id="formBtn">
        </form>
    </div>
</body>
</html>
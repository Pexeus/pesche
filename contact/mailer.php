<?php

//var_dump($_POST);

$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message_raw = $_POST["message"];

$header = array(
    'From' => 'webmaster@peterzaugg.ch',
    'Reply-To' => 'webmaster@peterzaugg.ch',
    'X-Mailer' => 'PHP/' . phpversion()
);

$message = $message_raw . "\n\n" . "Absender: " . $name . "\n\n" . "E-Mal des Absenders: " . $email;


mail("info@peterzaugg.ch", $subject, $message, $header);
?>
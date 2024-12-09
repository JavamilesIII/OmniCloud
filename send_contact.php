<?php
use PHPMailer\PHPMailer\PHPMailer;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $to = "loic.matthey@stude.edubs.ch";
    $subject = "Kontaktformular - " . $name;
    $headers = "From: " . $email . "\r\n";
    $headers .= "Bcc; damian.wyss@stud.edubs.ch, illia.hudz@stud.edubs.ch"."\r\n";
    mail($to, $subject, $message, $headers);
    header("Location: index.php");
}
?>
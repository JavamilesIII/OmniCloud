<?php
include 'functions.php';
$user = "admin";
$pass = "admin";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    if ($username === $user && $password === $pass) {
        $_SESSION["username"] = $username;
        header("Location: manage.php");
        exit();
    } else {
        echo "Ungültige Anmeldedaten. Bitte versuchen Sie es erneut.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="login.php" method="post">
        <fieldset>
            <legend>Login</legend>
            <div class="login">
                <label for="username">Username:</label><br>
                <input type="text" name="username" required>
                <br>
                <label for="password">Password:</label><br>
                <input type="password" name="password" required>
            </div>
            <br>
            <br>
            <input type="submit" id="login" value="Login">
            <br>
            <a href="index.php" class="logink">Zurück zur Startseite</a>
        </fieldset>
    </form>
</body>
</html>
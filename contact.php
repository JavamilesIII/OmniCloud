<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - Omnicloud</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <header>
        <h1>Kontakt</h1>
    </header>
    <section>
        <h2>Kontaktieren Sie uns</h2>
        <form action="send_contact.php" method="post">
            <table id="contact">
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" id="name" name="name" required></td>
                </tr>
                <tr>
                    <td><label for="email">E-Mail:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                </tr>
                <tr>
                    <td><label for="message">Nachricht:</label></td>
                    <td><textarea id="message" name="message" rows="5" required></textarea></td>
                </tr>
            </table>
        
            <button type="submit">Senden</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>
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
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="message">Nachricht:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
            <br>
            <button type="submit">Senden</button>
        </form>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>
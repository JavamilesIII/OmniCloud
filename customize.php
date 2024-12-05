<?php
require 'server.php';



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnicloud</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <header>
        <h1>Omnicloud</h1>
    <p></p>
    <form action="action.php" method="post" id="custom">
        <fieldset>
            <legend>CPU Cores</legend>
            <input type="radio" name="cores" id="cores" value="1" checked="checked">1 Core<br>
            <input type="radio" name="cores" id="cores" value="2">2 Cores<br>
            <input type="radio" name="cores" id="cores" value="4">4 Cores<br>
            <input type="radio" name="cores" id="cores" value="8">8 Cores<br>
            <input type="radio" name="cores" id="cores" value="16">16 Cores<br>
        </fieldset>
        <fieldset>
            <legend>Speicher</legend>
            <input type="radio" name="speicher" id="speicher" value="1024" checked="checked">1024GB<br>
            <input type="radio" name="speicher" id="speicher" value="2048">2048GB<br>
            <input type="radio" name="speicher" id="speicher" value="4096">4096GB<br>
            <input type="radio" name="speicher" id="speicher" value="8192">8192GB<br>
            <input type="radio" name="speicher" id="speicher" value="16384">16384GB<br>
            <input type="radio" name="speicher" id="speicher"><input type="number" name="speicher" id="speicher-input" min="32" max="32768" step="1.0">GB<br>
        </fieldset>
        <fieldset>
            <legend>Arbeitsspeicher (RAM)</legend>
            <input type="radio" name="ram" id="ram" value="8" checked="checked">8GB<br>
            <input type="radio" name="ram" id="ram" value="16">16GB<br>
            <input type="radio" name="ram" id="ram" value="32">32GB<br>
            <input type="radio" name="ram" id="ram" value="64">64GB<br>
            <input type="radio" name="ram" id="ram" value="128">128GB<br>
            <input type="radio" name="ram" id="ram"><input type="number" name="ram" id="ram-input" min="4" max="256" step="1.0">GB<br>
        </fieldset>
        <fieldset>
            <input type="submit" value="Anfrage senden" class="submit">
        </fieldset>
    </form>
    <br><br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>
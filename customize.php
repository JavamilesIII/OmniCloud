<?php
include 'preis.php';


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
    <form action="server.php" method="post" id="custom">
        <fieldset>
            <legend>CPU Cores</legend>
            <input type="radio" name="cores" id="cores" value="1" checked="checked" onchange="updatePrice()">1 Core <?= $preis = 'CHF '.ceil($preise['cpu']*1).'.-'?><br> 
            <input type="radio" name="cores" id="cores" value="2" onchange="updatePrice()">2 Cores <?= $preis = 'CHF '.ceil($preise['cpu']*2).'.-'?><br>
            <input type="radio" name="cores" id="cores" value="4" onchange="updatePrice()">4 Cores <?= $preis = 'CHF '.ceil($preise['cpu']*4).'.-'?><br>
            <input type="radio" name="cores" id="cores" value="8" onchange="updatePrice()">8 Cores <?= $preis = 'CHF '.ceil($preise['cpu']*8).'.-'?><br>
            <input type="radio" name="cores" id="cores" value="16" onchange="updatePrice()">16 Cores <?= $preis = 'CHF '.ceil($preise['cpu']*16).'.-'?><br>
        </fieldset>
        <fieldset>
            <legend>Speicher</legend>
            <input type="radio" name="speicher" id="speicher" value="1024" checked="checked" onchange="updatePrice()">1024GB <?= $preis = 'CHF '.ceil($preise['speicher']*1024).'.-'?><br><br>
            <input type="radio" name="speicher" id="speicher" value="2048" onchange="updatePrice()">2048GB <?= $preis = 'CHF '.ceil($preise['speicher']*2048).'.-'?><br><br>
            <input type="radio" name="speicher" id="speicher" value="4096" onchange="updatePrice()">4096GB <?= $preis = 'CHF '.ceil($preise['speicher']*4096).'.-'?><br><br>
            <input type="radio" name="speicher" id="speicher" value="8192" onchange="updatePrice()">8192GB <?= $preis = 'CHF '.ceil($preise['speicher']*8192).'.-'?><br><br>
            <input type="radio" name="speicher" id="speicher" value="16384" onchange="updatePrice()">16384GB <?= $preis = 'CHF '.ceil($preise['speicher']*16384).'.-'?><br><br>
            <input type="number" name="speicher_input" id="speicher-input" min="32" max="32768" step="1.0" onchange="updatePrice()">GB <?= $preis = 'CHF '.ceil($preise['speicher']*1).'.-'?>
            <br><br>
        </fieldset>
        <fieldset>
            <legend>Arbeitsspeicher (RAM)</legend>
            <input type="radio" name="ram" id="ram" value="8" checked="checked" onchange="updatePrice()">8GB <?= $preis = 'CHF '.ceil($preise['ram']*8).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="16" onchange="updatePrice()">16GB <?= $preis = 'CHF '.ceil($preise['ram']*16).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="32" onchange="updatePrice()">32GB <?= $preis = 'CHF '.ceil($preise['ram']*32).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="64" onchange="updatePrice()">64GB <?= $preis = 'CHF '.ceil($preise['ram']*64).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="128" onchange="updatePrice()">128GB <?= $preis = 'CHF '.ceil($preise['ram']*128).'.-'?><br><br>
            <input type="number" name="ram_input" id="ram-input" min="4" max="256" step="1.0" onchange="updatePrice()">GB <?= $preis = 'CHF '.ceil($preise['ram']*1).'.-'?>  
            <br><br>
        </fieldset>
        <fieldset>
            <script>
                function updatePrice() {
                    // Get the values of the radio buttons and number inputs
                    let speicherValue = document.getElementById('speicher-input').value;
                    let ramValue = document.getElementById('ram-input').value;
                    
                    // You can use these values to update the price
                    let speicherPrice = speicherValue * <?= $preise['speicher'] ?>;
                    let ramPrice = ramValue * <?= $preise['ram'] ?>;
                    
                    // Display or calculate the total price
                    let totalPrice = speicherPrice + ramPrice;
                    document.getElementById('total-price').innerText = 'Total Price: CHF ' + Math.ceil(totalPrice) + '.-';
                }
            </script>
            <input type="submit" value="Anfrage senden" class="submit">
        </fieldset>
    </form>
    <br><br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>
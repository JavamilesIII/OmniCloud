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
    <script>
                document.addEventListener("DOMContentLoaded", function () {
                    function updatePrice() {
                        let selectedCores = document.querySelector('input[name="cores"]:checked');
                        let coresValue = selectedCores ? parseInt(selectedCores.value) : 0;

                        
                        let selectedSSD = document.querySelector('input[name="ssd"]:checked');
                        let ssdValue = selectedSSD ? parseInt(selectedSSD.value) : 0;

                        
                        let selectedRam = document.querySelector('input[name="ram"]:checked');
                        let ramValue = selectedRam ? parseInt(selectedRam.value) : 0;

                        
                        let cpuPrice = <?= $preise['cpu'] ?>; 
                        let ssdPrice = <?= $preise['ssd'] ?>; 
                        let ramPrice = <?= $preise['ram'] ?>; 

                        
                        let totalPrice = (coresValue * cpuPrice) + (ssdValue * ssdPrice) + (ramValue * ramPrice);

                        
                        document.getElementById('price-display').innerText = 'CHF ' + Math.ceil(totalPrice) + '.-';
                    }

                   
                    updatePrice();

                    
                    document.querySelectorAll('input[name="cores"], input[name="ram"], input[name="ssd"]').forEach(function (input) {
                        input.addEventListener('change', updatePrice);
                    });
                });
            </script>
</head>
<body>
    <?php include 'header.php'; ?>
        <h1>Omnicloud</h1>
    <p></p>
    <form action="action.php" method="post" id="custom">
        <fieldset>
            <legend>CPU Cores</legend>
            <input type="radio" name="cores" id="cores" value="1" checked="checked" onchange="updatePrice()">1 Core <?= $preis = 'CHF '.ceil($preise['cpu']*1).'.-'?><br> 
            <input type="radio" name="cores" id="cores" value="2" onchange="updatePrice()">2 Cores <?= $preis = 'CHF '.ceil($preise['cpu']*2).'.-'?><br>
            <input type="radio" name="cores" id="cores" value="4" onchange="updatePrice()">4 Cores <?= $preis = 'CHF '.ceil($preise['cpu']*4).'.-'?><br>
            <input type="radio" name="cores" id="cores" value="8" onchange="updatePrice()">8 Cores <?= $preis = 'CHF '.ceil($preise['cpu']*8).'.-'?><br>
            <input type="radio" name="cores" id="cores" value="16" onchange="updatePrice()">16 Cores <?= $preis = 'CHF '.ceil($preise['cpu']*16).'.-'?><br>
            
        </fieldset>
        <fieldset>
            <legend>Arbeitsspeicher (RAM)</legend>
            <input type="radio" name="ram" id="ram" value="512" checked="checked" onchange="updatePrice()">512MB <?= $preis = 'CHF '.ceil($preise['ram']*512).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="1024" onchange="updatePrice()">1024MB <?= $preis = 'CHF '.ceil($preise['ram']*1024).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="2048" onchange="updatePrice()">2048MB <?= $preis = 'CHF '.ceil($preise['ram']*2048).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="4096" onchange="updatePrice()">4096MB <?= $preis = 'CHF '.ceil($preise['ram']*4096).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="8192" onchange="updatePrice()">8192MB <?= $preis = 'CHF '.ceil($preise['ram']*8192).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="16384" onchange="updatePrice()">16384MB <?= $preis = 'CHF '.ceil($preise['ram']*16384).'.-'?><br><br>
            <input type="radio" name="ram" id="ram" value="32768" onchange="updatePrice()">32768MB <?= $preis = 'CHF '.ceil($preise['ram']*32768).'.-'?><br><br>
            <!--<input type="number" name="ram_input" id="ram-input" min="4" max="256" step="1.0" onchange="updatePrice()">GB -->
            
        </fieldset>
        <fieldset>
            <legend>SSD</legend>
            <input type="radio" name="ssd" id="ssd" value="10" checked="checked" onchange="updatePrice()">10GB <?= $preis = 'CHF '.ceil($preise['ssd']*10).'.-'?><br><br>
            <input type="radio" name="ssd" id="ssd" value="20" onchange="updatePrice()">20GB <?= $preis = 'CHF '.ceil($preise['ssd']*20).'.-'?><br><br>
            <input type="radio" name="ssd" id="ssd" value="40" onchange="updatePrice()">40GB <?= $preis = 'CHF '.ceil($preise['ssd']*40).'.-'?><br><br>
            <input type="radio" name="ssd" id="ssd" value="80" onchange="updatePrice()">80GB <?= $preis = 'CHF '.ceil($preise['ssd']*80).'.-'?><br><br>
            <input type="radio" name="ssd" id="ssd" value="240" onchange="updatePrice()">240GB <?= $preis = 'CHF '.ceil($preise['ssd']*240).'.-'?><br><br>
            <input type="radio" name="ssd" id="ssd" value="500" onchange="updatePrice()">500GB <?= $preis = 'CHF '.ceil($preise['ssd']*500).'.-'?><br><br>
            <input type="radio" name="ssd" id="ssd" value="1000" onchange="updatePrice()">1000GB <?= $preis = 'CHF '.ceil($preise['ssd']*1000).'.-'?><br><br>
            <!--<input type="number" name="ssd_input" id="ssd-input" min="32" max="32768" step="1.0" onchange="updatePrice()">GB -->
            
        </fieldset>
        <fieldset>
            <p>Total Price: <span id="price-display">CHF 0.-</span></p> <br>
            <input type="submit" value="Anfrage senden" class="submit">
        </fieldset>
    </form>
    <br><br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>
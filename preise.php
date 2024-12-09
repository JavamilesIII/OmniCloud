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
        <h1>Preise</h1>
    <p></p>
    <br>
    <div id="preise">
        <div class="preise">
            <div class="package-title">
                <h2>Small Package</h2>
            </div>
            <ul>
                <li>CPU: 4 Cores</li>
                <li>RAM: 32GB</li>
                <li>SSD: 2048GB</li>
                <li>Preis: <?= $preis = ceil(($preise['cpu']*4) + ($preise['ram']*32) + ($preise['speicher']*2048)); ?> CHF/mo</li>
            </ul>
            <?php echo "<a href='server.php?package=small'>Jetzt kaufen</a>"; ?>
        </div>
        <div class="preise">
            <div class="package-title">
                <h2>Medium Package</h2>
            </div>
            <ul>
                <li>CPU: 8 Cores</li>
                <li>RAM: 64GB</li>
                <li>SSD: 4096GB</li>
                <li>Preis: <?= $preis = ceil(($preise['cpu']*8) + ($preise['ram']*64) + ($preise['speicher']*4096)); ?> CHF/mo</li>
            </ul>
            <?php echo "<a href='server.php?package=medium'>Jetzt kaufen</a>"; ?>
        </div>
        <div class="preise">
            <div class="package-title">
                <h2>Big Package</h2>
            </div>
            <ul>
                <li>CPU: 16 Cores</li>
                <li>RAM: 128GB</li>
                <li>SSD: 8192GB</li>
                <li>Preis: <?= $preis = ceil(($preise['cpu']*16) + ($preise['ram']*128) + ($preise['speicher']*8192)); ?> CHF/mo</li>
            </ul>
            <?php echo "<a href='server.php?package=big'>Jetzt kaufen</a>"; ?>
        </div>
        <div class="preise last">
            <div class="package-title">
                <h2>Custom</h2>
            </div>
            <p>Sie können selber customisieren</p>
            <a href="customize.php">Custom</a>
        </div>
    </div>
    <br><br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>
<?php
include 'preis.php';
include 'functions.php';

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
                <li>CPU: 1 Core</li>
                <li>RAM: 8192MB</li>
                <li>SSD: 20GB</li>
                <li>Preis: <?= $preis = ceil(($preise['cpu']*1) + ($preise['ram']*8192) + ($preise['ssd']*20)); ?> CHF/mo</li>
            </ul>
            <?php echo "<a href='server.php?package=small'>Jetzt kaufen</a>"; ?>
        </div>
        <div class="preise">
            <div class="package-title">
                <h2>Medium Package</h2>
            </div>
            <ul>
                <li>CPU: 2 Cores</li>
                <li>RAM: 16384MB</li>
                <li>SSD: 80GB</li>
                <li>Preis: <?= $preis = ceil(($preise['cpu']*2) + ($preise['ram']*16384) + ($preise['ssd']*80)); ?> CHF/mo</li>
            </ul>
            <?php echo "<a href='server.php?package=medium'>Jetzt kaufen</a>"; ?>
        </div>
        <div class="preise">
            <div class="package-title">
                <h2>Big Package</h2>
            </div>
            <ul>
                <li>CPU: 4 Cores</li>
                <li>RAM: 32768MB</li>
                <li>SSD: 240GB</li>
                <li>Preis: <?= $preis = ceil(($preise['cpu']*4) + ($preise['ram']*32768) + ($preise['ssd']*240)); ?> CHF/mo</li>
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
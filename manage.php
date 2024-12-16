<?php
include 'functions.php';
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Machines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <section id="manager">
    <?php
    if (isset($_GET['deleted'])) {
        $deletedIndex = intval($_GET['deleted']);
        deleteHosting($deletedIndex);
        header('Location: manage.php');
    }
    $cpu = 0;
    $ram = 0;
    $ssd = 0;
    if (file_exists('hosting.json')) {
        if($hosts = json_decode(file_get_contents('hosting.json'), true) ?? []){
            echo "<table id='manage' align ='center'><tr>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>CPU Cores</th>";
            echo "<th>RAM</th>";
            echo "<th>SSD</th>";
            echo "<th>Delete</th>";
            echo "<tr>";
            $i = 0;
            foreach ($hosts as $host) {
                echo "</tr>";
                echo "<td>{$host['name']}</td>";
                echo "<td>{$host['email']}</td>";
                echo "<td>{$host['cpu']} Kerne</td>";
                echo "<td>{$host['ram']} MB</td>";
                echo "<td>{$host['ssd']} GB</td>";
                echo "<td><a href='?deleted=$i' class='delete'>Delete</a></td>";
                echo "</tr>";
                $i++;
                $cpu += $host['cpu'];
                $ram += $host['ram'];
                $ssd += $host['ssd'];
            }
            
            echo "</table>";
            $umsatz = $cpu * 5 + $ram * 0.01 + $ssd * 0.5;
            echo "<p>Umsatz: $umsatz CHF</p>";
        }
        else {
            echo "<p>Keine Daten verfügbar</p>";
        }
    }
    
    ?>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>
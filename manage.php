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
    
    if (file_exists('hosting.json')) {
        if($hosts = json_decode(file_get_contents('hosting.json'), true) ?? []){
            echo "<table id='manage' align ='center'><tr>";
            echo "<th>User</th>";
            echo "<th>CPU Cores</th>";
            echo "<th>RAM</th>";
            echo "<th>SSD</th>";
            echo "<th>Delete</th>";
            echo "<tr>";
            $i = 0;
            foreach ($hosts as $host) {
                echo "</tr>";
                echo "<td>{$host['user']}</td>";
                echo "<td>{$host['cpu']}</td>";
                echo "<td>{$host['ram']}</td>";
                echo "<td>{$host['ssd']}</td>";
                echo "<td><a href='?deleted=$i' class='delete'>Delete</a></td>";
                echo "</tr>";
                $i++;
            }
            
            echo "</table>";
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
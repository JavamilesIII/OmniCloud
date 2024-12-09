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
    <?php
    $file = 'hosting.json';
    $hosts = [];
    if (file_exists($file)) {
        $hosts = json_decode(file_get_contents($file), true) ?? [];
    }
    foreach ($hosts as $host) {
        echo print_r($host);
        echo "<br>";
        echo $host['cpu'];
        echo "<br>";
    }
    ?>

    <?php include 'footer.php'; ?>
</body>
</html>
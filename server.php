<?php
include 'preis.php';
$file = 'hosting.json';
$page = 'server';
// Load initial server data or from server.json if it exists
$default_server = array(
    array('name' => 'Server 1', 'speicher' => 100000, 'ram' => 10000, 'cpu' => 128),
    array('name' => 'Server 2', 'speicher' => 100000, 'ram' => 10000, 'cpu' => 128),
    array('name' => 'Server 3', 'speicher' => 100000, 'ram' => 10000, 'cpu' => 128),
    array('name' => 'Server 4', 'speicher' => 100000, 'ram' => 10000, 'cpu' => 128),
    array('name' => 'Server 5', 'speicher' => 100000, 'ram' => 10000, 'cpu' => 128)
);


// Load server state from server.json or initialize to default
$server = json_decode(file_get_contents('server.json'), true) ?? $default_server;

$package_list = array(
    'small' => array('cpu' => 4, 'ram' => 32, 'speicher' => 2048),
    'medium' => array('cpu' => 8, 'ram' => 64, 'speicher' => 4096),
    'big' => array('cpu' => 16, 'ram' => 128, 'speicher' => 8192)
);

$server_capacity = [];

// Calculate capacity if server state exists
foreach ($server as $index => $values) {
    $server_capacity[$index] = (
        (($server[$index]['cpu'] / $default_server[$index]['cpu']) * 100) +
        (($server[$index]['ram'] / $default_server[$index]['ram']) * 100) +
        (($server[$index]['speicher'] / $default_server[$index]['speicher']) * 100)
    ) / 3;
}
$min_capacity = 0;
// Find the server with the minimum capacity
foreach ($server_capacity as $x) {
    if ($x > $min_capacity) {
        $min_capacity = array_search($x, $server_capacity);
    }
    elseif (empty($min_capacity)) {
        $min_capacity = array_search($x, $server_capacity);
        break;
    }
}
$current_data = [];
if (file_exists($file)) {
    $current_data = json_decode(file_get_contents($file), true) ?? [];
}
// Handle package selection via GET
$selected_package = $_GET['package'] ?? null;

if ($selected_package && isset($package_list[$selected_package])) {
    $message = "<strong>Selected Package:</strong><br>";
    foreach ($package_list[$selected_package] as $key => $value) {
        $message .= $key . ": " . $value . "<br>";
    }
    $selected_config = $package_list[$selected_package];
    $current_data[] = $selected_config;
    // Deduct resources from the server with the minimum capacity
    foreach ($package_list[$selected_package] as $key => $value) {
        if ($server[$min_capacity][$key] >= $value) {
            $server[$min_capacity][$key] -= $value;
        } else {
            $message = "<strong>Error:</strong> Not enough $key available on {$server[$min_capacity]['name']}!<br>";
        }
    }
}

// Handle custom configuration via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cores = intval($_POST['cores']);
    if(!empty(trim($_POST['ram_input']))){
        $ram = intval($_POST['ram_input']);
    }
    else{
        $ram = intval($_POST['ram']);
    }
    if(!empty(trim($_POST['speicher_input']))){
        $speicher = intval($_POST['speicher_input']);
    }
    else{
        $speicher = intval($_POST['speicher']);
    }
    $custom_config = array(
        'cpu' => $cores,
        'ram' => $ram,
        'speicher' => $speicher
    );
    $current_data[] = $custom_config;
    if ($server[$min_capacity]['cpu'] >= $cores && $server[$min_capacity]['ram'] >= $ram && $server[$min_capacity]['speicher'] >= $speicher) {
        $server[$min_capacity]['cpu'] -= $cores;
        $server[$min_capacity]['ram'] -= $ram;
        $server[$min_capacity]['speicher'] -= $speicher;
    } else {
        $message = "<strong>Error:</strong> Not enough resources available for the custom configuration!<br>";
    }
}
file_put_contents('hosting.json', json_encode($current_data, JSON_PRETTY_PRINT));

// Write the updated server data to server.json
file_put_contents('server.json', json_encode($server, JSON_PRETTY_PRINT));

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php
    if (!empty($message)) {
        echo "<div class='message'>$message</div>";
    }
    if($page === 'server'){
        $package = $_GET['package'] ?? null; // Paket abfragen

        if ($package && isset($package_list[$package])) {
            // Nachricht anzeigen, wenn ein Paket ausgewählt wurde
            echo "
            <section>
                <h1>Vielen Dank für Ihre Bestellung!</h1>
                <p>Sie haben das <span class='package-title'>" . htmlspecialchars($package) . "</span> Paket gewählt.</p>
                <p>Wir werden uns in Kürze mit weiteren Details bei Ihnen melden.</p>
                <a href='index.php' class='btn'>Zurück zur Startseite</a>
            </section>";
    }
    }
    ?>

    <?php include 'footer.php'; ?>
</body>
</html>
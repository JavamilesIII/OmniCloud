<?php
include 'preis.php';
$file = 'hosting.json';
$page = 'server';
// Load initial server data or from server.json if it exists
$default_server = array(
    array('name' => 'small', 'ssd' => 4000, 'ram' => 32768, 'cpu' => 4),
    array('name' => 'medium', 'ssd' => 8000, 'ram' => 65536, 'cpu' => 8),
    array('name' => 'big', 'ssd' => 16000, 'ram' => 131072, 'cpu' => 16)
);


// Load server state from server.json or initialize to default
$server = json_decode(file_get_contents('server.json'), true) ?? $default_server;

$package_list = array(
    'small' => array('cpu' => 1, 'ram' => 8192, 'ssd' => 20),
    'medium' => array('cpu' => 2, 'ram' => 16384, 'ssd' => 80),
    'big' => array('cpu' => 4, 'ram' => 32768, 'ssd' => 240)
);

$server_capacity = [];

// Calculate capacity if server state exists
foreach ($server as $index => $values) {
    $server_capacity[$index] = (
        (($server[$index]['cpu'] / $default_server[$index]['cpu']) * 100) +
        (($server[$index]['ram'] / $default_server[$index]['ram']) * 100) +
        (($server[$index]['ssd'] / $default_server[$index]['ssd']) * 100)
    ) / 3;
}
var_dump($server_capacity);
echo "<br>";
$min_capacity = 0;
// Find the server with the minimum capacity
/*foreach ($server_capacity as $x) {
    if ($x > $min_capacity) {
        
    }
    elseif (empty($min_capacity)) {
        $min_capacity = array_search($x, $server_capacity);
        break;
    }
}*/

// Handle package selection via GET
$selected_package = $_GET['package'] ?? null;

if ($selected_package && isset($package_list[$selected_package])) {
    $message = "<strong>Selected Package:</strong><br>";
    foreach ($package_list[$selected_package] as $key => $value) {
        $message .= $key . ": " . $value . "<br>";
    }
    $selected_config = $package_list[$selected_package];
    
    // Deduct resources from the server with the minimum capacity
    $can_allocate = true;
    foreach ($package_list[$selected_package] as $key => $value) {
        if ($server[$min_capacity][$key] < $value) {
            $can_allocate = false;
            $message = "<strong>Error:</strong> Not enough $key available on Server {$server[$min_capacity]['name']}!<br>";
            break;
        }
    }
    if ($can_allocate) {
        foreach ($package_list[$selected_package] as $key => $value) {
            $server[$min_capacity][$key] -= $value;
        }
        $current_data[] = $selected_config;
    }
}

// Handle custom configuration via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cores = intval($_POST['cores']);
    /*if(!empty(trim($_POST['ram_input']))){
        $ram = intval($_POST['ram_input']);
    }
    else{*/
    $ram = intval($_POST['ram']);
    //}
    /*if(!empty(trim($_POST['ssd_input']))){
        $ssd = intval($_POST['ssd_input']);
    }
    else{*/
    $ssd = intval($_POST['ssd']);
    //}
    $custom_config = array(
        'cpu' => $cores,
        'ram' => $ram,
        'ssd' => $ssd
    );
    $min_capacity = array_keys($server_capacity, min($server_capacity))[0];
    echo "Server Index with Min Capacity: " . $min_capacity . "<br>";
    $current_data = [];
    if (file_exists($file)) {
        $current_data = json_decode(file_get_contents($file), true) ?? [];
    }
    while (($server[$min_capacity]['cpu'] < $cores) || ($server[$min_capacity]['ram'] < $ram) || ($server[$min_capacity]['ssd'] < $ssd)){
        if($min_capacity===2){
            $message = "<strong>Error:</strong> Not enough resources available for the custom configuration!<br>";
            die();
        }
        $min_capacity++;
        
    }
    var_dump($server);
    echo "<br>";
    var_dump($custom_config);
    echo "<br>";
    echo "Server Index with Min Capacity: " . $min_capacity . "<br>";
    var_dump($server[$min_capacity]);


    if ($server[$min_capacity]['cpu'] >= $cores && $server[$min_capacity]['ram'] >= $ram && $server[$min_capacity]['ssd'] >= $ssd) {
        $server[$min_capacity]['cpu'] -= $cores;
        $server[$min_capacity]['ram'] -= $ram;
        $server[$min_capacity]['ssd'] -= $ssd;
        $current_data[] = $custom_config;
    } else {
        $message = "<strong>Error:</strong> Not enough resources available for the custom configuration!<br>";
    }
}
if(!empty($current_data)){
    if (file_put_contents('hosting.json', json_encode($current_data, JSON_PRETTY_PRINT)) === false) {
        die("<strong>Error:</strong> Unable to write to hosting.json");
    }
}

if (!file_exists('server.json') || empty($server)) {
    file_put_contents('server.json', json_encode($default_server, JSON_PRETTY_PRINT));
    $server = $default_server;
}


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
            $package_title = htmlspecialchars($package);
            echo "
            <section>
                <h1>Vielen Dank für Ihre Bestellung!</h1>
                <p>Sie haben das <span class='package-title'>{$package_title}</span> Paket gewählt.</p>
                <p>Wir werden uns in Kürze mit weiteren Details bei Ihnen melden.</p>
                <a href='index.php' class='btn'>Zurück zur Startseite</a>
            </section>";
        }
        
    }
    ?>

    <?php include 'footer.php'; ?>
</body>
</html>
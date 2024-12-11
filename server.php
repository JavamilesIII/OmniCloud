<?php
include 'preis.php';
include 'functions.php';
session_start();

$successful =true;

$default_server = array(
    array('name' => 'small', 'ssd' => 4000, 'ram' => 32768, 'cpu' => 4),
    array('name' => 'medium', 'ssd' => 8000, 'ram' => 65536, 'cpu' => 8),
    array('name' => 'big', 'ssd' => 16000, 'ram' => 131072, 'cpu' => 16)
);


$user = 0;
$server = json_decode(file_get_contents('server.json'), true) ?? $default_server;

$package_list = array(
    'small' => array('cpu' => 1, 'ram' => 8192, 'ssd' => 20),
    'medium' => array('cpu' => 2, 'ram' => 16384, 'ssd' => 80),
    'big' => array('cpu' => 4, 'ram' => 32768, 'ssd' => 240)
);

$server_capacity = [];


foreach ($server as $index => $values) {
    $server_capacity[$index] = (
        (($server[$index]['cpu'] / $default_server[$index]['cpu']) * 100) +
        (($server[$index]['ram'] / $default_server[$index]['ram']) * 100) +
        (($server[$index]['ssd'] / $default_server[$index]['ssd']) * 100)
    ) / 3;
}

$min_capacity = array_keys($server_capacity, max($server_capacity))[0];

$selected_package = $_GET['package'] ?? null;
$m = '';
if (!isset($_SESSION['script_executed'])) {
    if (file_exists("hosting.json")) {
        $current_data = json_decode(file_get_contents("hosting.json"), true) ?? [];
    }
    if (!empty($current_data)) {
        // Get the last user's identifier
        $last_user = end($current_data)['user']; // Assuming 'user' key exists in the data
        // Extract the number part from the string (e.g., 'user0' -> 0)
        $user_number = intval(preg_replace('/[^0-9]/', '', $last_user));
        // Increment the user number
        $user_number++;
    } else {
        // Default to user0 if no data exists
        $user_number = 0;
    }
    $user = "user$user_number";
    //print_r($user);
    while(True){
        $m = "";
        if ($selected_package && isset($package_list[$selected_package])) {
            
            foreach ($package_list[$selected_package] as $key => $value) {
                $m .= $key . ": " . $value . "<br>";
            }
            $cores = $package_list[$selected_package]['cpu'];
            $ram = $package_list[$selected_package]['ram'];
            $ssd = $package_list[$selected_package]['ssd'];
            if(($server[$min_capacity]['cpu'] < $cores) || ($server[$min_capacity]['ram'] < $ram) || ($server[$min_capacity]['ssd'] < $ssd)){
                $min_capacity++;
                if($min_capacity>2){
                    $message = "<strong>Error:</strong> Not enough resources available!<br>";
                    $successful = false;
                    break;
                }
                continue;
            }
            $selected_config = $package_list[$selected_package];
            

            $can_allocate = true;
            foreach ($package_list[$selected_package] as $key => $value) {
                if ($server[$min_capacity][$key] < $value) {
                    $can_allocate = false;
                    $message = "<strong>Error:</strong> Not enough resources available!<br>";
                    $successful = false;
                    break;
                }
            }
            if ($can_allocate) {
                foreach ($package_list[$selected_package] as $key => $value) {
                    $server[$min_capacity][$key] -= $value;
                }
                $current_data[] = array_merge(['user' => $user], $selected_config);
                
            }
            //var_dump($current_data);
            break;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selected_package = "custom";
            $cores = intval($_POST['cores']);
            $ram = intval($_POST['ram']);
            $ssd = intval($_POST['ssd']);
            if(($server[$min_capacity]['cpu'] < $cores) || ($server[$min_capacity]['ram'] < $ram) || ($server[$min_capacity]['ssd'] < $ssd)){
                $min_capacity++;
                if($min_capacity>2){
                    $message = "<strong>Error:</strong> Not enough resources available!<br>";
                    $successful = false;
                    break;
                }
                continue;
            }
            $custom_config = array(
                'cpu' => $cores,
                'ram' => $ram,
                'ssd' => $ssd
            );
            
            
        
            if ($server[$min_capacity]['cpu'] >= $cores && $server[$min_capacity]['ram'] >= $ram && $server[$min_capacity]['ssd'] >= $ssd) {
                $server[$min_capacity]['cpu'] -= $cores;
                $server[$min_capacity]['ram'] -= $ram;
                $server[$min_capacity]['ssd'] -= $ssd;
                $current_data[] = array_merge(['user' => $user], $custom_config);

            } else {
                $message = "<strong>Error:</strong> Not enough resources available for the custom configuration!<br>";
                $successful = false;
            }
            break;
        }
    }
    $_SESSION['script_executed']=true;
    
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
else {
    file_put_contents('server.json', json_encode($server, JSON_PRETTY_PRINT));
    $server = $default_server;
}
if ($successful != false){
    $package_title = htmlspecialchars($selected_package);
    $message = "
            <section>
                <h1>Vielen Dank für Ihre Bestellung!</h1>
                <p>Sie haben das <span class='package-title'>".strtoupper($package_title)."</span> Paket gewählt.</p>
                <p>Details zum Paket:</p>
                $m 
                <p>Wir werden uns in Kürze mit weiteren Details bei Ihnen melden.</p>
                <a href='index.php?exit=1' class='btn'>Zurück zur Startseite</a>

            </section>";
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
    ?>

    <?php include 'footer.php'; ?>
</body>
</html>
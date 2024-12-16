<?php
include 'preis.php';
include 'functions.php';
include 'action.php';
echo "<br>";
$successful =true;

$default_server = array(
    array('name' => 'small', 'ssd' => 4000, 'ram' => 32768, 'cpu' => 4),
    array('name' => 'medium', 'ssd' => 8000, 'ram' => 65536, 'cpu' => 8),
    array('name' => 'big', 'ssd' => 16000, 'ram' => 131072, 'cpu' => 16)
);


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
$personal_info = $_SESSION['personal_info']??null;
echo "<br>";
$min_capacity = array_keys($server_capacity, max($server_capacity))[0];
$cores = 0;
$ram = 0;
$ssd = 0;
$selected_package = $_SESSION['selected_package'] ?? null;
$m = '';
if ($_SESSION['script_executed'] != true) {
    if (file_exists("hosting.json")) {
        $current_data = json_decode(file_get_contents("hosting.json"), true) ?? [];
    }
    
    $user = $personal_info['email'];
    $total_available_cpu = 0;
    $total_available_ram = 0;
    $total_available_ssd = 0;

    foreach ($server as $s) {
        $total_available_cpu += $s['cpu'];
        $total_available_ram += $s['ram'];
        $total_available_ssd += $s['ssd'];
    }

    if ($cores > $total_available_cpu || $ram > $total_available_ram || $ssd > $total_available_ssd) {
        $message1 = "<strong>Error:</strong> Angeforderte Ressourcen übersteigen die Gesamtkapazität des Systems!<br>";
        $successful = false;
    } else {
        while(True){
            $m = "";
            if ($selected_package && isset($package_list[$selected_package['name']])) {
                $package_name = $selected_package['name'];
                foreach ($package_list[$package_name] as $key => $value) {
                    $m .= $key . ": " . $value . "<br>";
                }
                $cores = $package_list[$package_name]['cpu'];
                $ram = $package_list[$package_name]['ram'];
                $ssd = $package_list[$package_name]['ssd'];
                if(($server[$min_capacity]['cpu'] < $cores) || ($server[$min_capacity]['ram'] < $ram) || ($server[$min_capacity]['ssd'] < $ssd)){
                    $min_capacity++;
                    if($min_capacity>2){
                        $message1 = "<strong>Error:</strong> Nicht genügend Ressourcen zur Verfügung!<br>";
                        $successful = false;
                        break;
                    }
                    continue;
                }
                $selected_config = $package_list[$package_name];
            

                $can_allocate = true;
                foreach ($package_list[$package_name] as $key => $value) {
                    if ($server[$min_capacity][$key] < $value) {
                        $can_allocate = false;
                        $message1 = "<strong>Error:</strong> Nicht genügend Ressourcen zur Verfügung!<br>";
                        $successful = false;
                        break;
                    }
                }
                if ($can_allocate) {
                    foreach ($package_list[$package_name] as $key => $value) {
                        $server[$min_capacity][$key] -= $value;
                    }
                    $current_data[] = array_merge(['name' => $personal_info['name'], 'email' => $personal_info['email']], $selected_config);
                
                }
                break;
            }
        
            if (isset($_SESSION['selected_package']['name']) && $_SESSION['selected_package']['name'] == "custom") {
                $selected_package = $_SESSION['selected_package'];
                $cores = intval($selected_package['cores']);
                $ram = intval($selected_package['ram']);
                $ssd = intval($selected_package['ssd']);
                if(($server[$min_capacity]['cpu'] < $cores) || ($server[$min_capacity]['ram'] < $ram) || ($server[$min_capacity]['ssd'] < $ssd)){
                    $min_capacity++;
                    if($min_capacity>2){
                        $message1 = "<strong>Error:</strong> Nicht genügend Ressourcen zur Verfügung!<br>";
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
                foreach ($custom_config as $key => $value) {
                    $m .= $key . ": " . $value . "<br>";
                }

            
            
        
                if ($server[$min_capacity]['cpu'] >= $cores && $server[$min_capacity]['ram'] >= $ram && $server[$min_capacity]['ssd'] >= $ssd) {
                    $server[$min_capacity]['cpu'] -= $cores;
                    $server[$min_capacity]['ram'] -= $ram;
                    $server[$min_capacity]['ssd'] -= $ssd;
                    $current_data[] = array_merge(['name' => $personal_info['name'], 'email' => $personal_info['email']], $custom_config);

                } else {
                    $message1 = "<strong>Error:</strong> Nicht genügend Ressourcen zur Verfügung!<br>";
                    $successful = false;
                }
                break;
            }
        }
    }    $_SESSION['script_executed']=true;
    
}




if ($successful){
    $package_title = is_array($selected_package) ? $selected_package['name'] : $selected_package;
    $package_title = htmlspecialchars($package_title);
    $message1 = "
                <h1>Vielen Dank für Ihre Bestellung!</h1>
                <p>Sie haben das <span class='package-title'>".strtoupper($package_title)."</span> Paket gewählt.</p>
                <p>Details zum Paket:</p>
                <p>Name: " . htmlspecialchars($personal_info['name']) . "</p>
                <p>E-Mail: " . htmlspecialchars($personal_info['email']) . "</p>
                <br>
                $m
                <p>Bitte merken Sie sich Ihr Benutzername um den Server zu löschen.</p>
                <p>Wir werden uns in Kürze mit weiteren Details bei Ihnen melden.</p>";
}
else{
    $message1 = "<strong>Error:</strong> Bestellung abgebrochen!<br>";
}
if(!empty($current_data)){
    if (file_put_contents('hosting.json', json_encode($current_data, JSON_PRETTY_PRINT)) === false) {
        $message1="<strong>Error:</strong> Kann nicht in hosting.json schreiben!";
        die;
    }
}

if (!empty($server)) {
    file_put_contents('server.json', json_encode($server, JSON_PRETTY_PRINT));
} else {
    file_put_contents('server.json', json_encode($default_server, JSON_PRETTY_PRINT));
    $server = $default_server;
}
$message = "
        <section>
            $message1
            
            <a href='index.php?exit=1' class='btn'>Zurück zur Startseite</a>
        </section>
"
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
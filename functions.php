<?php
function deleteHosting($index) {
    $default_server = array(
        array('name' => 'small', 'ssd' => 4000, 'ram' => 32768, 'cpu' => 4),
        array('name' => 'medium', 'ssd' => 8000, 'ram' => 65536, 'cpu' => 8),
        array('name' => 'big', 'ssd' => 16000, 'ram' => 131072, 'cpu' => 16)
    );

    $current_data = json_decode(file_get_contents('hosting.json'), true) ?? [];
    $server = json_decode(file_get_contents('server.json'), true) ?? [];
    
    if (!isset($current_data[$index])) {
        die("Error: Invalid index for deletion!");
    }

    $daten = $current_data[$index];

    // Attempt to find a server with capacity to restore the resources
    for ($min_capacity = 0; $min_capacity < count($server); $min_capacity++) {
        $can_restore = true;

        foreach (['cpu', 'ram', 'ssd'] as $resource) {
            if (($server[$min_capacity][$resource] + $daten[$resource]) > $default_server[$min_capacity][$resource]) {
                $can_restore = false;
                break;
            }
        }

        if ($can_restore) {
            foreach (['cpu', 'ram', 'ssd'] as $resource) {
                $server[$min_capacity][$resource] += $daten[$resource];
            }
            unset($current_data[$index]); // Remove the specific hosting entry
            file_put_contents('server.json', json_encode($server, JSON_PRETTY_PRINT));
            file_put_contents('hosting.json', json_encode(array_values($current_data), JSON_PRETTY_PRINT)); // Re-index
            return;
        }
    }

    // If no server can accommodate the resources
    die("Error: Too many resources to restore!");
}
function logout(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    session_destroy();

}
if (isset($_GET['exit'])) {
    logout();
}
function check_login()
{
	
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        return true;
    }
	
	header("Location: login.php");
	die;
}

?>

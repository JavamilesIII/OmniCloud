<?php
ini_set('session.gc_maxlifetime', 3600);
session_start();

// If coming from preise.php
if (!isset($_SESSION['script_executed'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Save package details to the session
        $_SESSION['selected_package'] = [
            'name' => 'custom',
            'cores' => htmlspecialchars($_POST['cores']),
            'ram' => htmlspecialchars($_POST['ram']),
            'ssd' => htmlspecialchars($_POST['ssd']),
        ];
    } elseif (isset($_GET['package']) && ($selected_package = htmlspecialchars($_GET['package']))) {
        $_SESSION['selected_package'] = ['name' => $selected_package];
    }
    $_SESSION['script_executed'] = true;
}

// On form submission, save personal info
if (isset($_POST['personal_submit'])) {
    $personal_info = [
        'name' => htmlspecialchars($_POST['name']),
        'email' => htmlspecialchars($_POST['email']),
    ];
    $_SESSION['personal_info'] = $personal_info;

    // Redirect to server.php after submission
    $_SESSION['script_executed'] = false;
    header('Location: server.php');
    exit;
}

// Display the form only if this script is accessed directly
if (basename($_SERVER['PHP_SELF']) === 'action.php') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persönliche Daten</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Persönliche Daten</h1>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit" name="personal_submit">Absenden</button>
    </form>
</body>
</html>
<?php
}
?>

<?php
session_start();

// Read the JSON data from the users file
$dataFile = 'users.json';
$users = json_decode(file_get_contents($dataFile), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user['name'];  // Store the user's name in the session
            header('Location: index.php');
            exit;
        }
    }

    // If authentication fails
    echo '<p>Invalid email or password.</p>';
}
?>

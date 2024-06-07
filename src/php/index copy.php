<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Home</title>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow-md w-96 text-center">
            <h2 class="text-2xl font-bold mb-6">Welcome!</h2>
            <p>You are logged in as <?php echo htmlspecialchars($_SESSION['email']); ?>.</p>
            <form action="logout.php" method="POST">
                <button type="submit" class="mt-4 bg-red-500 text-white py-2 px-4 rounded">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>

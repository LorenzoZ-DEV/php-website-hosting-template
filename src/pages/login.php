<?php
session_start();

// Dati utenti
$utenti = [
    'admin' => 'admin',
    'user' => 'ciao'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    
    if (isset($utenti[$username]) && $utenti[$username] === $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Credenziali errate. Riprova.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="background"></div>
        <form method="POST" action="login.php" class="login-form">
            <h2>Login</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <div class="input-container">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="login-button">Accedi</button>
            <a href="main.php" class="home-button">← Torna alla Home</a> <!-- Nuovo link per tornare alla home -->
        </form>
    </div>
</body>
</html>

<?php
session_start();

// Connessione al database
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "vlessy";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);



// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $confirm_password = htmlspecialchars($_POST['confirm_password'] ?? '');

    if ($password !== $confirm_password) {
        $error = "Le password non coincidono. Riprova.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        try {
            $stmt->bind_param("s", $username);
        } catch (Exception $e) {
            $error = "Errore durante la verifica del nome utente: " . $e->getMessage();
        }
        $stmt->execute();
        $stmt->store_result();
    

        if ($stmt->num_rows > 0) {
            $error = "Nome utente già esistente. Scegli un altro nome utente.";
        } else {
            // Aggiungi il nuovo utente
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Errore durante la registrazione. Riprova.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register-container">
        <div class="background"></div>
        <form method="POST" action="register.php" class="register-form">
            <h2>Registrazione</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <div class="input-container">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Conferma Password" required>
            </div>
            <button type="submit" class="register-button">Registrati</button>
            <a href="main.php" class="home-button">← Torna alla Home</a>
            <a href="login.php" class="login-button">Sei già registrato? Accedi</a>
        </form>
    </div>
</body>
</html>
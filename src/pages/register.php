
<?php
session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $confirm_password = htmlspecialchars($_POST['confirm_password'] ?? '');

    if ($password !== $confirm_password) {
        $error = "Le password non coincidono. Riprova.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param("s", $username);
        } else {
            $error = "Errore durante la preparazione della query: " . $conn->error;
        }
        try{
            $stmt->execute();
        } catch (Exception $e) {
            $error = "Errore durante l'esecuzione della query: " . $e->getMessage();
        }
        try{
            $stmt->store_result();
        } catch (Exception $e) {
            $error = "Errore durante lo store del risultato: " . $e->getMessage();
        }    

        if ($stmt->num_rows > 0) {
            echo "<div id='notification' style='color: yellow; font-weight: bold; background: linear-gradient(to right, #ffffcc,rgb(233, 99, 45)); padding: 10px; position: fixed; top: 900px; right: 10px; z-index: 1000; display: flex; align-items: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 5px;'>
            <svg xmlns='http://www.w3.org/2000/svg' style='margin-right: 10px;' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-info'>
            <circle cx='12' cy='12' r='10'></circle>
            <line x1='12' y1='16' x2='12' y2='12'></line>
            <line x1='12' y1='8' x2='12' y2='8'></line>
            </svg>
            Nome utentè esiste già..
        </div>";
        echo "<script>
        setTimeout(function() {
        var notification = document.getElementById('notification');
        notification.style.transition = 'opacity 1s ease-out, top 1s ease-out';
        notification.style.opacity = '0';
        notification.style.top = '0px';
        setTimeout(function() {
            notification.style.display = 'none';
        }, 1000);
        }, 5000);
        </script>";
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
                echo "<div id='notification' style='color: red; font-weight: bold; background: linear-gradient(to right, #ffffcc,rgb(238, 22, 22)); padding: 10px; position: fixed; top: 900px; right: 10px; z-index: 1000; display: flex; align-items: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 5px;'>
                <svg xmlns='http://www.w3.org/2000/svg' style='margin-right: 10px;' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-info'>
                <circle cx='12' cy='12' r='10'></circle>
                <line x1='12' y1='16' x2='12' y2='12'></line>
                <line x1='12' y1='8' x2='12' y2='8'></line>
                </svg>
                Errore durante la registrazione
            </div>";   
            echo "<script>
            setTimeout(function() {
            var notification = document.getElementById('notification');
            notification.style.transition = 'opacity 1s ease-out, top 1s ease-out';
            notification.style.opacity = '0';
            notification.style.top = '0px';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 1000);
            }, 5000);
            </script>"; 
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
        
<?php
session_start();

/*
Copyright (c) 2025 Vanixy

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

// Controlla se l'utente è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

// Simulazione di un servizio attivo
$activeService = [
    'name' => 'Hosting VPS-2',
    'price' => '3.99€',
    'renewalDate' => '2025-02-15',
];         
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Utente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="panel-container">
        <div class="panel">
            <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Questo è il tuo pannello utente riservato. Qui puoi gestire i tuoi servizi.</p>
            
            <div class="service-details">
                <h3>Servizio Attivo</h3>
                <ul>
                    <li><strong>Tipo di Servizio:</strong> <?php echo htmlspecialchars($activeService['name']); ?></li>
                    <li><strong>Prezzo Mensile:</strong> <?php echo htmlspecialchars($activeService['price']); ?></li>
                    <li><strong>Data di Rinnovo:</strong> <?php echo htmlspecialchars($activeService['renewalDate']); ?></li>
                </ul>
            </div>

            <div class="action-buttons">
                <a href="update_service.php" class="update-button">Aggiorna Servizio</a>
                <a href="delete_service.php" class="delete-button">Cancella Servizio</a>
            </div>

            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>
</html>

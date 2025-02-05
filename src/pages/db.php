<?php

$host = "localhost"; 
$usr = "root";
$pwd = "";
$db = "vlessy";

try {
    $conn = new mysqli($host, $usr, $pwd, $db);

    if ($conn->connect_error) {
        throw new Exception("Connessione fallita: " . $conn->connect_error);
    }

    $checkTableQuery = "SHOW TABLES LIKE 'users'";
    $result = $conn->query($checkTableQuery);

    if ($result->num_rows > 0) {
        echo "<div style='color: orange; font-weight: bold; background: linear-gradient(to right, #ffffcc, #ffcc00); padding: 10px;'>Avviso [DEBUG]: La tabella 'users' esiste già.</div>";
    } else {
        $tablequery = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";

        if ($conn->query($tablequery) === TRUE) {
            echo "Tabella creata con successo";
        } else {
            throw new Exception("Si è verificato un problema durante la creazione della tabella: " . $conn->error);
        }
    }
} catch (Exception $e) {
    echo "<div style='color: red; font-weight: bold; background: linear-gradient(to right, #ffcccc, #ff6666); padding: 10px;'>Errore [DEBUG]: " . $e->getMessage() . "</div>";
}
?>
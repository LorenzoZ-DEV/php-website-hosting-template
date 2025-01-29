<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="pages/style.css">
</head>
<body>
    <div class="container">
    <div class="rendirect">
        <h1>Redirecting...</h1>
        <p>Se non sei reindirizzato automaticamente clicca <a href="pages/main.php">qui</a></p>
        <script>
            setTimeout(() => {
                window.location.href = 'pages/main.php';
            }, 3000);
        </script>
    </div>
    </div>

</body>
</html> 
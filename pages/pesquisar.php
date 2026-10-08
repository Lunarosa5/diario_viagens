<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Pesquise</h1>
        <form action="" method="POST">
            <label for="destino">Insira o seu destino para encontrar a viagem desejada:</label> <br>
            <input type="text" name="destino" id="destino" required>
            <input type="submit" value="Pesquisar">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            pesquisar($conexao, $_POST['destino']);
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
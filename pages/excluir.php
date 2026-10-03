<?php
session_start();
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php'; 

// Se o usuário clicou para excluir uma viagem específica
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir') {
    excluir($conexao, $_POST['id_viagem'], $_SESSION['id_usuario']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Viagem - Travely</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <h1>Apague o relato de uma viagem</h1>

        <!-- Formulário para pesquisar qual viagem deseja apagar -->
        <form action="" method="POST">
            <label for="destino">Insira o destino da viagem que deseja apagar:</label><br>
            <input type="text" name="destino" id="destino" required>
            <input type="submit" name="acao" value="Buscar para Excluir">
        </form>

        <?php
        // Exibe os resultados para exclusão
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['destino'])) {
            echo "<h2>Selecione a viagem para excluir:</h2>";
            pesquisar_para_excluir($conexao, $_POST['destino']);
        }
        ?>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
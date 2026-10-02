<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Nova Viagem - Travely</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <h1>Descreva sua nova viagem</h1>
        
        <!-- Formulário para adicionar uma nova viagem, incluindo campos para destino, datas, relato, fotos e avaliação. -->
        <form action="" method="post">
            <label for="destino">Adicione o destino: </label><br>
            <input type="text" name="destino" id="destino" required><br><br>

            <label for="data_inicio">Data de inicio da viagem: </label>
            <input type="date" name="data_inicio" id="data_inicio" required>

            <label for="data_fim">Data de fim da viagem: </label>
            <input type="date" name="data_fim" id="data_fim" required><br><br>

            <label for="relato">Descreva-a: </label><br>
            <textarea name="relato" id="relato" rows="4" cols="50" required></textarea><br><br>

            <label for="imagem">Adicione fotos da viagem: </label>
            <input type="file" name="imagem" id="imagem" accept="image/*"><br><br>

            <label for="avaliacao">De uma nota de 0 à 5: </label>
            <input type="number" name="avaliacao" id="avaliacao" min="0" max="5" required><br><br>

            <input type="reset" value="Limpar">
            <input type="submit" value="Salvar">
        </form>

        <?php

        // Quando o formulário é enviado por POST, a função cadastrar_viagem é executa
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Pega o ID do usuário logado da sessão e cria um título para a viagem com base no destino informado pelo usuário.
            $id_usuario = $_SESSION['id_usuario'];
            $titulo = "Viagem para " . $_POST['destino'];

            // Chama a função cadastrar_viagem para salvar os dados da viagem no banco de dados. Se a função retornar true, exibe uma mensagem de sucesso; caso contrário, exibe uma mensagem de erro.
            if (cadastrar_viagem($conexao, $id_usuario, $titulo, $_POST['destino'], $_POST['data_inicio'], $_POST['data_fim'], $_POST['relato'], $_POST['avaliacao'])) {
                echo "<p>Viagem cadastrada com sucesso!</p>";
            } else {
                echo "<p>Erro ao cadastrar viagem.</p>";
            }
        }
        ?>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
<?php
session_start();

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';

$hoje = date('Y-m-d');
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

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id_usuario = $_SESSION['id_usuario'];
            $titulo = "Viagem para " . $_POST['destino'];

            $id_viagem_criada = cadastrar_viagem(
                $conexao, 
                $id_usuario, 
                $titulo, 
                $_POST['destino'], 
                $_POST['data_inicio'], 
                $_POST['data_fim'], 
                $_POST['relato'], 
                $_POST['avaliacao']
            );

            if ($id_viagem_criada) {
                if (!empty($_FILES['imagem']['name'])) {
                    foto_viagem($conexao, $id_viagem_criada, $_FILES['imagem']);
                }

                echo "<p>Viagem cadastrada com sucesso!</p>";
                // Limpa o $_POST após salvar com sucesso para o formulário resetar
                $_POST = array();
            }
        }
        ?>
        
        <form action="" method="post" enctype="multipart/form-data">
            <label for="destino">Adicione o destino: </label><br>
            <input type="text" name="destino" id="destino" value="<?= htmlspecialchars($_POST['destino'] ?? ''); ?>" required><br><br>

            <label for="data_inicio">Data de inicio da viagem: </label>
            <input type="date" name="data_inicio" id="data_inicio" max="<?= $hoje; ?>" value="<?= htmlspecialchars($_POST['data_inicio'] ?? ''); ?>" required>

            <label for="data_fim">Data de fim da viagem: </label>
            <input type="date" name="data_fim" id="data_fim" max="<?= $hoje; ?>" value="<?= htmlspecialchars($_POST['data_fim'] ?? ''); ?>" required><br><br>

            <label for="relato">Descreva-a: </label><br>
            <textarea name="relato" id="relato" rows="4" cols="50" required><?= htmlspecialchars($_POST['relato'] ?? ''); ?></textarea><br><br>

            <label for="imagem">Adicione fotos da viagem: </label>
            <input type="file" name="imagem" id="imagem" accept="image/*"><br><br>

            <label for="avaliacao">De uma nota de 0 à 5: </label>
            <input type="number" name="avaliacao" id="avaliacao" min="0" max="5" value="<?= htmlspecialchars($_POST['avaliacao'] ?? ''); ?>" required><br><br>

            <input type="reset" value="Limpar">
            <input type="submit" value="Salvar">
        </form>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
<?php
session_start();
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php'; 

$hoje = date('d-m-Y');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar relato - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <h1>Atualize suas anotações</h1>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'atualizar') {
            atualizar(
                $conexao, 
                $_POST['id_viagem'], 
                $_POST['destino'], 
                $_POST['data_inicio'], 
                $_POST['data_fim'], 
                $_POST['avaliacao'], 
                $_POST['relato'], 
                $_SESSION['id_usuario']
            );

            if (isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])) {
                foto_viagem($conexao, $_POST['id_viagem'], $_FILES['imagem']);
            }
        }
        ?>

        <!-- Busca pelo local -->
        <form action="" method="POST">
            <label for="destino_busca"><strong>Local:</strong></label><br>
            <input type="text" name="destino_busca" id="destino_busca" placeholder="Insira o local da sua viagem" required>
            <input type="submit" name="acao" value="Buscar">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['destino_busca']) && $_POST['acao'] == 'Buscar') {
            $viagens = pesquisar_opcoes($conexao, $_POST['destino_busca']);

            if (empty($viagens)) {
                echo "<p>Nenhuma viagem encontrada para este destino.</p>";
            } else {
                echo "<h2>Selecione a viagem para atualizar:</h2>";

                foreach ($viagens as $viagem) {
                    $fotos = buscar_fotos_viagem($conexao, $viagem['id']);
                    $src = !empty($fotos) ? '../uploads/' . $fotos[0]['nome_arquivo'] : '../images/sem-foto.png';
        ?>
                    <div class="espaço-viagem">
                        <div class="caixa-imagem">
                            <img src="<?= htmlspecialchars($src); ?>" alt="Foto de <?= htmlspecialchars($viagem['destino']); ?>">
                        </div>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_viagem" value="<?= $viagem['id']; ?>">
                            <input type="hidden" name="acao" value="atualizar">

                            <label>Alterar foto da viagem:</label><br>
                            <input type="file" name="imagem" accept="image/*"><br><br>

                            <label>Destino:</label><br>
                            <input type="text" name="destino" value="<?= htmlspecialchars($viagem['destino']); ?>" required><br><br>

                            <label>Data de Início:</label><br>
                            <input type="date" name="data_inicio" value="<?= $viagem['data_inicio']; ?>" max="<?= $hoje; ?>" required><br><br>

                            <label>Data de Fim:</label><br>
                            <input type="date" name="data_fim" value="<?= $viagem['data_fim']; ?>" max="<?= $hoje; ?>" required><br><br>

                            <label>Dê uma nota de 0 à 5:</label><br>
                            <input type="number" name="avaliacao" min="0" max="5" value="<?= $viagem['avaliacao']; ?>" required><br><br>

                            <label>Relato:</label><br>
                            <textarea name="relato" rows="4" cols="50" required><?= htmlspecialchars($viagem['relato'] ?? ''); ?></textarea><br><br>

                            <input type="submit" value="Salvar Alterações">
                        </form>
                        <hr>
                    </div>
        <?php
                }
            }
        }
        ?>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
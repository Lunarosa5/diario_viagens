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
    <link rel="stylesheet" href="../css/style.css">
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
            $viagens = pesquisar_opcoes($conexao, $_POST['destino']);

            if (empty($viagens)) {
                echo "<p>Nenhuma viagem encontrada para este destino.</p>";
            } else {
                echo "<h2>Selecione a viagem para excluir:</h2>";

                foreach ($viagens as $viagem) {
                    $fotos = buscar_fotos_viagem($conexao, $viagem['id']);
                    $src = !empty($fotos) ? '../uploads/' . $fotos[0]['nome_arquivo'] : '../images/sem-foto.png';
        ?>
                    <div class="espaço-viagem">
                        <div class="caixa-imagem">
                            <img src="<?= htmlspecialchars($src); ?>" alt="Foto de <?= htmlspecialchars($viagem['destino']); ?>">
                        </div>

                        <div class="info-viagem">
                            <h3><?= htmlspecialchars($viagem['destino']); ?></h3>
                            <p>Data: <?= date('d/m/Y', strtotime($viagem['data_inicio'])); ?></p>
                            <p>Nota: <?= htmlspecialchars($viagem['avaliacao']); ?></p>

                            <form action="" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar este relato?');">
                                <input type="hidden" name="id_viagem" value="<?= $viagem['id']; ?>">
                                <input type="hidden" name="acao" value="excluir">
                                <input type="submit" value="Excluir relato">
                            </form>
                        </div>
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
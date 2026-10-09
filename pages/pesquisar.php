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

<body class="fundo-dashboard">
    <div class="dashboard-container">
        <?php include __DIR__ . '/../includes/header.php'; ?>

        <main class="dashboard-conteudo-pesquisar">
            <!-- Botão Voltar -->
            <a href="inicio.php" class="btn-voltar-link">&#129144; Voltar</a>

            <h1 class="titulo-pagina">Encontre uma viagem</h1>

            <form action="" method="POST" class="form-pesquisa">
                <div class="campo-pesquisa-grupo">
                    <input type="text" name="destino" id="destino" placeholder="Insira o local da sua viagem" value="<?= htmlspecialchars($_POST['destino'] ?? ''); ?>" required class="input-pesquisa">
                    <input type="submit" value="Buscar" class="btn-buscar">
                </div>
            </form>

            <div class="resultado-pesquisa-container">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $resultados = pesquisar_opcoes($conexao, $_POST['destino']);

                    if (!empty($resultados)) {
                        foreach ($resultados as $viagem) {
                            $fotos = buscar_fotos_viagem($conexao, $viagem['id']);
                            $caminho_imagem = !empty($fotos) ? '../uploads/' . $fotos[0]['nome_arquivo'] : '../images/sem_imagem.png';
                            ?>
                            <div class="espaco-viagem">
                                <div class="caixa-imagem">
                                    <img src="<?= htmlspecialchars($caminho_imagem); ?>" alt="Foto de <?= htmlspecialchars($viagem['destino']); ?>">
                                </div>

                                <div class="info-viagem">
                                    <p class="titulo-local"><strong><?= htmlspecialchars($viagem['destino']); ?></strong></p>
                                    <p>Data: <span><?= date('d/m/Y', strtotime($viagem['data_inicio'])); ?></span></p>
                                    <p>Nota: <span><?= htmlspecialchars($viagem['avaliacao']); ?></span></p>

                                    <a href="detalhes_viagem.php?id=<?= $viagem['id']; ?>&origem=pesquisar" class="btn-ver-mais">Ver mais</a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p class='sem-viagens'>Nenhuma viagem encontrada para este destino.</p>";
                    }
                }
                ?>
            </div>
        </main>

        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>
</body>

</html>
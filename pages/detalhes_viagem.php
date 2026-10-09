<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';

$id_usuario = $_SESSION['id_usuario'];

// 1. Verifica se o ID veio na URL (ex: detalhes_viagem.php?id=3)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: viagens.php");
    exit();
}

$id_viagem = (int)$_GET['id'];

// 2. Define o destino do botão "Voltar" com base no parâmetro 'origem' da URL
$origem = isset($_GET['origem']) ? $_GET['origem'] : 'viagens';

if ($origem === 'inicio') {
    $link_voltar = 'inicio.php';
} elseif ($origem === 'pesquisar.php') {
    $link_voltar = 'pesquisar.php';
} elseif ($origem === 'excluir.php') {
    $link_voltar = 'excluir.php';
} elseif ($origem === 'atualizar.php') {
    $link_voltar = 'atualizar.php'; }

// 3. Busca a viagem no banco de dados
$sql = "SELECT * FROM viagens WHERE id = :id AND id_usuario = :id_usuario";
$stmt = $conexao->prepare($sql);
$stmt->bindValue(':id', $id_viagem, PDO::PARAM_INT);
$stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$viagem = $stmt->fetch(PDO::FETCH_ASSOC);

// Se não achar a viagem ou não pertencer ao usuário logado, volta pra página de origem
if (!$viagem) {
    header("Location: " . $link_voltar);
    exit();
}

// 4. Busca as fotos cadastradas ou a foto padrão sem_imagem.png
$fotos = buscar_fotos_viagem($conexao, $viagem['id']);
$lista_fotos = [];

if (!empty($fotos)) {
    foreach ($fotos as $f) {
        $lista_fotos[] = '../uploads/' . $f['nome_arquivo'];
    }
} else {
    $lista_fotos[] = '../images/sem_imagem.png';
}

$total_fotos = count($lista_fotos);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($viagem['titulo']); ?> - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fundo-dashboard">
    <div class="dashboard-container">
        <?php include __DIR__ . '/../includes/header.php'; ?>

        <main class="dashboard-conteudo-detalhes">
            <!-- Botão Voltar -->
            <a href="<?php echo $link_voltar; ?>" class="btn-voltar-link">⬅ Voltar</a>

            <h1 class="titulo-detalhe-viagem"><?php echo htmlspecialchars($viagem['titulo']); ?></h1>

            <div class="card-detalhe-container">
                
                <div class="carrossel-css">
                    <?php for ($i = 0; $i < $total_fotos; $i++): ?>
                        <input type="radio" name="carrossel_foto" id="foto-<?= $i; ?>" <?= ($i === 0) ? 'checked' : ''; ?>>
                    <?php endfor; ?>

                    <div class="foto-detalhe-caixa">
                        <?php foreach ($lista_fotos as $index => $caminho): ?>
                            <img src="<?php echo htmlspecialchars($caminho); ?>" alt="Foto de <?php echo htmlspecialchars($viagem['destino']); ?>" class="slide-foto foto-<?= $index; ?>">
                        <?php endforeach; ?>
                    </div>

                    <?php if ($total_fotos > 1): ?>
                        <div class="controles-setas">
                            <?php for ($i = 0; $i < $total_fotos; $i++):
                                $anterior = ($i - 1 + $total_fotos) % $total_fotos;
                                $proxima = ($i + 1) % $total_fotos;
                            ?>
                                <div class="grupo-setas seta-grupo-<?= $i; ?>">
                                    <label for="foto-<?= $anterior; ?>" class="seta-carrossel seta-esquerda">❬</label>
                                    <label for="foto-<?= $proxima; ?>" class="seta-carrossel seta-direita">❭</label>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="info-detalhe-conteudo">
                    <div class="campo-info">
                        <h3>Data:</h3>
                        <div class="pilula-info">
                            <?php echo date('d/m/Y', strtotime($viagem['data_inicio'])); ?> - <?php echo date('d/m/Y', strtotime($viagem['data_fim'])); ?>
                        </div>
                    </div>

                    <div class="campo-info">
                        <h3>Avaliação:</h3>
                        <div class="pilula-info pilula-curta">
                            <?php echo htmlspecialchars($viagem['avaliacao']); ?>
                        </div>
                    </div>

                    <div class="campo-info">
                        <div class="campo-info">
                            <h3>Relato:</h3>
                            <textarea class="caixa-relato-info" rows="5" readonly><?php echo htmlspecialchars($viagem['relato']); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>
</body>

</html>
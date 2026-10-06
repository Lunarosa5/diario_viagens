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

// 2. Busca a viagem direto aqui, sem precisar de função nova no functions.php
$sql = "SELECT * FROM viagens WHERE id = :id AND id_usuario = :id_usuario";
$stmt = $conexao->prepare($sql);
$stmt->bindValue(':id', $id_viagem, PDO::PARAM_INT);
$stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$viagem = $stmt->fetch(PDO::FETCH_ASSOC);

// Se não achar a viagem ou não pertencer ao usuário logado, volta pra lista
if (!$viagem) {
    header("Location: viagens.php");
    exit();
}

// 3. Usa a tua função REAIS que já existe no functions.php para pegar a foto!
$fotos = buscar_fotos_viagem($conexao, $viagem['id']);
$caminho_imagem = !empty($fotos) ? '../uploads/' . $fotos[0]['nome_arquivo'] : '../css/placeholder.png';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($viagem['titulo']); ?> - Travely</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="detalhes-viagem">
        <!-- Título da viagem vindo da variável $titulo gravada no banco -->
        <h1><?php echo htmlspecialchars($viagem['titulo']); ?></h1>

        <a href="./viagens.php">Voltar</a>

        <div class="detalhes">
            <!-- Lado Esquerdo: Imagem da Viagem -->
            <div class="foto-detalhe">
                <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" 
                     alt="Foto de <?php echo htmlspecialchars($viagem['destino']); ?>">
            </div>

            <!-- Lado Direito: Informações e Relato -->
            <div class="info-detalhe">
                <p><strong>Data:</strong><br>
                    <?php echo date('d/m/Y', strtotime($viagem['data_inicio'])); ?> - <?php echo date('d/m/Y', strtotime($viagem['data_fim'])); ?>
                </p>

                <p><strong>Avaliação:</strong><br>
                    <?php echo htmlspecialchars($viagem['avaliacao']); ?>
                </p>

                <p><strong>Relato:</strong><br>
                    <?php echo nl2br(htmlspecialchars($viagem['relato'])); ?>
                </p>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
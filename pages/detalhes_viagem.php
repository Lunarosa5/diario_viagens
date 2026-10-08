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
} else {
    $link_voltar = 'viagens.php';
}

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

// 4. Busca a foto cadastrada ou a foto padrão sem_imagem.png
$fotos = buscar_fotos_viagem($conexao, $viagem['id']);
$caminho_imagem = !empty($fotos) ? '../uploads/' . $fotos[0]['nome_arquivo'] : '../images/sem_imagem.png';
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

        <main class="detalhes-viagem">
            <h1><?php echo htmlspecialchars($viagem['titulo']); ?></h1>

            <!-- O link do botão Voltar agora muda dinamicamente conforme a origem -->
            <a href="<?php echo $link_voltar; ?>" class="btn-ver-mais">Voltar</a>

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
    </div>
</body>

</html>
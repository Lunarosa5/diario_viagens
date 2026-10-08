<?php session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';

// Pega o ID do usuário que está logado
$id_usuario = $_SESSION['id_usuario'];

// Busca os dados da dashboard (Total, Média, Dias)
$dados = dados_dashboard($conexao, $id_usuario);

// Busca a lista das últimas viagens
$ultimas_viagens = ultimas_viagens($conexao, $id_usuario);

// Formata a média de notas para mostrar bonito (ex: 4.5)
if ($dados['media_notas']) {
    $media_notas = number_format($dados['media_notas'], 1);
} else {
    $media_notas = '0';
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fundo-dashboard">

    <div class="dashboard-container">

        <?php include __DIR__ . '/../includes/header.php'; ?>

        <main class="dashboard">
            <!-- Espaços com os dados da dashboard -->
            <div class="cards-topo">
                <div class="espaco-dashboard">
                    <h3>Total de viagens:</h3>
                    <p class="valor-espaco"><?php echo $dados['total_viagens'] ?? 0; ?></p>
                </div>

                <div class="espaco-dashboard">
                    <h3>Média de avaliações:</h3>
                    <p class="valor-card"><?php echo $media_notas; ?></p>
                </div>

                <div class="espaco-dashboard">
                    <h3>Dias em viagens:</h3>
                    <p class="valor-card"><?php echo $dados['dias_viagens'] ?? 0; ?></p>
                </div>
            </div>

            <hr class="divisor-dashboard">

            <!-- Seção das últimas viagens -->
            <section class="ultimas-viagens">
                <h2>Últimas viagens:</h2>

                <!-- Espaço para mostrar as últimas viagens relatadas pelo usuário -->
                <div class="viagens">

                    <!-- Se houver viagens, exibe o loop -->
                    <?php if (!empty($ultimas_viagens)): ?>

                        <?php foreach ($ultimas_viagens as $viagem): 
                            // Busca as fotos salvas para esta viagem
                            $fotos = buscar_fotos_viagem($conexao, $viagem['id']);
                            
                            // Define o caminho da imagem de capa ou sem_imagem.png
                            if (!empty($fotos)) {
                                $caminho_imagem = '../uploads/' . $fotos[0]['nome_arquivo'];
                            } else {
                                $caminho_imagem = '../images/sem_imagem.png';
                            }
                        ?>
                            <div class="espaco-viagem">
                                <div class="imagem-viagem">
                                    <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" alt="Foto da viagem">
                                </div>

                                <div class="info-viagem">
                                    <p class="titulo-local"><strong><?php echo htmlspecialchars($viagem['destino']); ?></strong></p>
                                    <p>Data: <span><?php echo date('d/m/Y', strtotime($viagem['data_inicio'])); ?></span></p>
                                    <p>Nota: <span><?php echo htmlspecialchars($viagem['avaliacao']); ?></span></p>

                                    <a href="detalhes_viagem.php?id=<?php echo $viagem['id']; ?>&origem=inicio" class="btn-ver-mais">Ver mais</a>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <p class="sem-viagens">Nenhuma viagem cadastrada ainda.</p>
                    <?php endif; ?>

                </div>
            </section>
        </main>

        <?php include __DIR__ . '/../includes/footer.php'; ?>

    </div>

</body>

</html>
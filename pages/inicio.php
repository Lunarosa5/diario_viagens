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
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="dashboard">
        <!-- Espaços com os dados da dashboard -->
        <div class="espaco-dashboard">
            <h3>Total de viagens:</h3>
            <p class="valor-espaco"><?php echo $dados['total_viagens'] ?? 0; ?></p>

            <!-- ?? 0: serve para evitar que o PHP mostre um aviso de erro na tela quando o valor for nulo ou não existir. -->

        </div>

        <div class="espaco-dashboard">
            <h3>Média de notas:</h3>
            <p class="valor-card"><?php echo $media_notas; ?></p>
        </div>

        <div class="espaco-dashboard">
            <h3>Dias em viagens:</h3>
            <p class="valor-card"><?php echo $dados['dias_viagens'] ?? 0; ?></p>
        </div>

        <hr>

        <!-- Seção das últimas viagens -->
        <section class="ultimas-viagens">
            <h2>Últimas viagens:</h2>

            <!-- Espaço para mostrar as últimas viagens relatadas pelo usuário -->
            <div class="viagens">

                <!-- Se não houver viagens, mostra uma mensagem -->
                <?php if (!empty($ultimas_viagens)): ?>

                    <!-- Loop para mostrar cada viagem -->
                    <?php foreach ($ultimas_viagens as $viagem): ?>
                        <div class="espaco-viagem">
                            <div class="imagem-viagem">
                                <img src="<?php echo !empty($viagem['imagem']) ? $viagem['imagem'] : '../css/placeholder.png'; ?>" alt="Foto da viagem">
                            </div>

                            <div class="info-viagem">
                                <p><strong>Local:</strong> <?php echo htmlspecialchars($viagem['local']); ?></p>
                                <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($viagem['data_inicio'])); ?></p>
                                <p><strong>Nota:</strong> <?php echo $viagem['nota']; ?></p>

                                <a href="viagens.php?id=<?php echo $viagem['id']; ?>" class="btn-ver-mais">Ver mais</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma viagem cadastrada ainda.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
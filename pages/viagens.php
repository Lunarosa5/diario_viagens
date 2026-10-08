<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php'; 
require_once __DIR__ . '/../database/connect.php';

// Procura a lista de viagens através da função limpa
$viagens = relatorio($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas viagens - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="fundo-dashboard">
    <div class="dashboard-container">
        
        <?php include __DIR__ . '/../includes/header.php'; ?>

        <main class="dashboard-conteudo-viagens">
            <h1 class="titulo-pagina">Minhas viagens</h1>

            <div class="viagens">
                <?php if (!empty($viagens)): ?>
                    
                    <?php foreach ($viagens as $viagem): 
                        // Procura as fotos cadastradas para esta viagem
                        $fotos = buscar_fotos_viagem($conexao, $viagem['id']);
                        
                        // Define o caminho da imagem de capa ou a foto padrão sem_imagem.png
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

                                <a href="detalhes_viagem.php?id=<?php echo $viagem['id']; ?>&origem=viagens" class="btn-ver-mais">Ver mais</a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p class="sem-viagens">Nenhuma viagem cadastrada ainda.</p>
                <?php endif; ?>
            </div>
        </main>

        <?php include __DIR__ . '/../includes/footer.php'; ?>

    </div>
</body>
</html>
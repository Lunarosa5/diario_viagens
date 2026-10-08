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
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fundo-dashboard">
    <div class="dashboard-container">

        <?php include __DIR__ . '/../includes/header.php'; ?>

        <main class="dashboard-conteudo-form">
            <h1 class="titulo-pagina">Descreva sua nova viagem</h1>

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

                    // Envolvido na div container-mensagem para centralizar no meio da tela
                    echo "<div class='container-mensagem'><p class='caixa-mensagem sucesso'>Viagem cadastrada com sucesso!</p></div>";
                    $_POST = array();
                } else {
                    echo "<div class='container-mensagem'><p class='caixa-mensagem erro'>Erro ao cadastrar a viagem.</p></div>";
                }
            }
            ?>

            <div class="card-formulario">
                <form action="" method="post" enctype="multipart/form-data" class="form-viagem">

                    <!-- Campo Destino (Largura Total) -->
                    <div class="campo-form largura-total">
                        <label for="destino">Adicione o destino:</label>
                        <input type="text" name="destino" id="destino" value="<?= htmlspecialchars($_POST['destino'] ?? ''); ?>" required>
                    </div>

                    <!-- Datas Lado a Lado -->
                    <div class="campo-form metade">
                        <label for="data_inicio">Data de inicio da viagem:</label>
                        <input type="date" name="data_inicio" id="data_inicio" max="<?= $hoje; ?>" value="<?= htmlspecialchars($_POST['data_inicio'] ?? ''); ?>" required>
                    </div>

                    <div class="campo-form metade">
                        <label for="data_fim">Data de fim da viagem:</label>
                        <input type="date" name="data_fim" id="data_fim" max="<?= $hoje; ?>" value="<?= htmlspecialchars($_POST['data_fim'] ?? ''); ?>" required>
                    </div>

                    <!-- Descrição (Largura Total) -->
                    <div class="campo-form largura-total">
                        <label for="relato">Descreva-a:</label>
                        <textarea name="relato" id="relato" rows="3" required><?= htmlspecialchars($_POST['relato'] ?? ''); ?></textarea>
                    </div>

                    <!-- Foto e Nota Lado a Lado -->
                    <div class="campo-form metade">
                        <label for="imagem">Adicione uma foto da viagem:</label>
                        <input type="file" name="imagem" id="imagem" accept="image/*">
                    </div>

                    <div class="campo-form metade">
                        <label for="avaliacao">De uma nota de 0 à 5:</label>
                        <input type="number" name="avaliacao" id="avaliacao" min="0" max="5" value="<?= htmlspecialchars($_POST['avaliacao'] ?? ''); ?>" required>
                    </div>

                    <!-- Botões de Ação Centralizados -->
                    <div class="container-botoes">
                        <input type="reset" value="Limpar" class="btn-form btn-limpar">
                        <input type="submit" value="Salvar" class="btn-form btn-salvar">
                    </div>
                </form>
            </div>
        </main>

        <?php include __DIR__ . '/../includes/footer.php'; ?>

    </div>
</body>

</html>
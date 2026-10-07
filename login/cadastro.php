<?php
// cadastro.php: interface de cadastro
session_start();

require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu cadastro - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fundo-cadastro">

    <!-- Lado Esquerdo - Formulário (Metade da Tela) -->
    <div class="cadastro-lado-form">
        
        <!-- Botão de Voltar no canto superior esquerdo -->
        <a href="../index.php" class="cadastro-botao-voltar">⬅ Voltar</a>

        <div class="cadastro-conteudo-central">
            <h2>Faça seu cadastro</h2>

            <form action="" method="POST">
                
                <div class="cadastro-campo">
                    <label for="nome">Nome de usuario:</label>
                    <input type="text" name="nome" id="nome" placeholder="Insira seu nome" required>
                </div>

                <div class="cadastro-campo">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="Insira seu email" required>
                </div>

                <div class="cadastro-campo">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" placeholder="Crie uma senha" required>
                </div>

                <div class="cadastro-container-submit">
                    <input type="submit" value="Cadastrar" class="cadastro-botao-submit">
                </div>

            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (cadastrar_user($conexao, $_POST['nome'], $_POST['email'], $_POST['senha'])) {
                    header("Location: ../pages/inicio.php");
                    exit();
                }
            }
            ?>
        </div>

    </div>

    <!-- Lado Direito - Imagem (Outra Metade da Tela) -->
    <div class="cadastro-lado-imagem"></div>

</body>

</html>
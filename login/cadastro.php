<?php
// -----------------------------------------------------------------------------
// ARQUIVO: login/register.php
// OBJETIVO: Interface de cadastro e chamada da função cadastrar_user()
// -----------------------------------------------------------------------------

// Inclui o ficheiro de funções centralizadas (que já puxa a conexão PDO)
require_once __DIR__ . '/../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu cadastro - Travely</title>
    <!-- Caminho relativo para a pasta css/ -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fundo">

    <!-- Contentor com visual dividido ao meio (Canva) -->
    <div class="container-dividido">

        <!-- Lado Esquerdo: Formulário de Cadastro -->
        <div class="lado-formulario">
            <h2>Faça seu cadastro</h2>

            <form action="" method="POST">
                <div class="campo">
                    <label for="nome">Nome de usuário:</label>
                    <input type="text" name="nome" id="nome" placeholder="Insira seu nome" required>
                </div>

                <div class="campo">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="Insira seu e-mail" required>
                </div>

                <div class="campo">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" placeholder="Crie uma senha" required>
                </div>

                <input type="submit" value="Cadastrar" class="botao-submit">
            </form>

            <?php
            // Quando o formulário é enviado por POST, executa a função cadastrar_user
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                cadastrar_user($conexao, $_POST['nome'], $_POST['email'], $_POST['senha']);
            }
            ?>

            <!-- Botão de Voltar para a Página Inicial -->
            <p class="texto-voltar"><a href="../index.php"> Voltar para a tela inicial</a></p>
        </div>

        <!-- Lado Direito: Imagem -->
        <div class="lado-imagem">
            <div class="caixa-imagem">
                <span>Imagem</span>
            </div>
        </div>

    </div>

</body>

</html>
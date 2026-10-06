<?php
// cadastro.php: interface de cadastro


// Inicia a sessão do usuário, permitindo que a aplicação armazene informações do usuário durante a navegação
session_start();

// Inclui o arquivo das funções e do banco de dados
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu cadastro - Travely</title>

</head>

<body class="fundo">
    <div class="lado-form">

        <!-- Formulário de Cadastro -->
        <div class="lado-form">
            <h2>Faça seu cadastro</h2>

            <!-- O formulário envia os dados do usuário para a mesma página (cadastro.php) usando o método POST. -->
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
            // Quando o formulário é enviado por POST
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                // Executa a função. Se der certo, redireciona para a tela de início
                if (cadastrar_user($conexao, $_POST['nome'], $_POST['email'], $_POST['senha'])) {
                    header("Location: ../pages/inicio.php");
                    exit();
                }
            }
            ?>

            <!-- Botão de Voltar para a Página Inicial -->
            <p class="texto-voltar"><a href="../index.php"> Voltar para a tela inicial</a></p>
        </div>

        <!-- Lado Direito - Imagem -->
        <div class="lado-imagem">
            <div class="caixa-imagem">
                <span>Imagem</span>
            </div>
        </div>

    </div>

</body>

</html>
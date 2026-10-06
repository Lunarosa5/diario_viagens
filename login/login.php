<?php // login.php: interface de login, verificação de senha e criação da Sessão

// Inclui as funções centralizadas do sistema
require_once __DIR__ . '/../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu login - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fundo">

    <div class="lado-form">

        <!-- Formulário de Login -->
        <div class="lado-form">
            <h2>Faça seu login</h2>

            <form action="" method="POST">
                <div class="campo">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="Insira seu e-mail" required>
                </div>

                <div class="campo">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" placeholder="Insira sua senha" required>
                </div>

                <input type="submit" value="Entrar" class="botao-submit">
            </form>

            <?php
            // Quando o formulário é enviado por POST, executa a função consulta_user
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $usuario = consulta_user($conexao, $_POST['email']);

                // Verifica o usuário e senha coma função "password_verify", que compara a senha e o hash.
                if ($usuario && password_verify($_POST['senha'], $usuario['senha'])) {
                    // Se tudo ocorrer bem, a sessão do PHP se inicia, permitindo que o servidor se "lembre" do usuário enquanto ele usa o site
                    session_start();

                    $_SESSION['id_usuario'] = $usuario['id'];
                    // Salva o ID do usuário na sessão para manter o login ativo nas outras páginas


                    // Após o usuário realizar o logjn, ele é redirecionado para a página de início do sistema
                    header("Location: ../pages/inicio.php");
                    exit();
                    // exit() é usado para garantir que o script seja encerrado após o redirecionamento, evitando que qualquer código seja executado a mais.

                } else {
                    
                    // Caso alguma das informações estiverem incorretas, uma mensagem é exibida
                    echo "<p class='alerta erro'>E-mail ou senha inválidos.</p>";
                }
            }
            ?>

            <p class="texto-cadastrar">Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>

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
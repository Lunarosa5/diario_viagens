<?php 
// login.php: interface de login, verificação de senha e criação da Sessão
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

<body class="fundo-login">

    <!-- Lado Esquerdo - Formulário (Metade da Tela) -->
    <div class="login-lado-form">
        
        <!-- Botão de Voltar no canto superior esquerdo -->
        <a href="../index.php" class="login-botao-voltar">⬅ Voltar</a>

        <div class="login-conteudo-central">
            <h2>Faça o login</h2>

            <form action="" method="POST">
                <div class="login-campo">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="Insira seu email" required>
                </div>

                <div class="login-campo">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" placeholder="Insira sua senha" required>
                </div>

                <div class="login-container-submit">
                    <input type="submit" value="Entrar" class="login-botao-submit">
                </div>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $usuario = consulta_user($conexao, $_POST['email']);

                if ($usuario && password_verify($_POST['senha'], $usuario['senha'])) {
                    session_start();
                    $_SESSION['id_usuario'] = $usuario['id'];
                    header("Location: ../pages/inicio.php");
                    exit();
                } else {
                    echo "<p class='alerta erro'>E-mail ou senha inválidos.</p>";
                }
            }
            ?>

            <p class="login-texto-cadastrar">Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
        </div>

    </div>

    <!-- Lado Direito - Imagem do Cristo Redentor -->
    <div class="login-lado-imagem"></div>

</body>
</html>
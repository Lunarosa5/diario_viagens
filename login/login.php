<?php
// -----------------------------------------------------------------------------
// ARQUIVO: login/login.php
// OBJETIVO: Interface de login, verificação de senha e criação da Sessão
// -----------------------------------------------------------------------------

// Inicia a sessão para podermos armazenar os dados do utilizador autenticado
session_start();

// Inclui as funções centralizadas do sistema
require_once __DIR__ . '/../includes/functions.php';

$mensagem = "";

// Processa a validação quando o utilizador clica em "Entrar"
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (!empty($email) && !empty($senha)) {
        // Usa a função consulta_user() para procurar o utilizador na BD pelo e-mail
        $usuario = consulta_user($conexao, $email);

        // Se encontrou o utilizador E a senha bate com a hash criptografada
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Guarda as informações essenciais na sessão do PHP
            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            // Redireciona para o feed de viagens na pasta pages/
            header("Location: ../pages/select.php");
            exit();
        } else {
            $mensagem = "<p class='alerta erro'>E-mail ou senha incorretos!</p>";
        }
    } else {
        $mensagem = "<p class='alerta erro'>Preencha e-mail e senha!</p>";
    }
}
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

    <!-- Contentor com visual dividido ao meio (Canva) -->
    <div class="container-dividido">

        <!-- Lado Esquerdo: Formulário de Login -->
        <div class="lado-formulario">
            <h2>Faça seu login</h2>

            <!-- Exibe alertas de erro se existirem -->
            <?php if (!empty($mensagem)) echo $mensagem; ?>

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

           <p class="texto-troca">Já tem uma conta? <a href="login.php">Faça login</a></p>
            
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
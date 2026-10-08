<?php
session_start();

require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';

$id_usuario = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Perfil - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <h1>Editar dados do Perfil</h1>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha_atual = $_POST['senha_atual'];
            $senha_nova = $_POST['senha_nova'];

            // Chama a função e ela mesma faz o echo da mensagem
            atualizar_perfil($conexao, $id_usuario, $nome, $email, $senha_atual, $senha_nova);
        }

        // Busca os dados do utilizador para preencher os campos do formulário
        $usuario = buscar_usuario($conexao, $id_usuario);
        ?>

        <form action="" method="POST">
            <label for="nome">Nome:</label><br>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($_POST['nome'] ?? $usuario['nome']); ?>" required><br><br>

            <label for="email">E-mail:</label><br>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? $usuario['email']); ?>" required><br><br>

            <label for="senha_atual">Senha Atual:</label><br>
            <input type="password" name="senha_atual" id="senha_atual" required><br><br>

            <label for="senha_nova">Nova Senha (opcional):</label><br>
            <input type="password" name="senha_nova" id="senha_nova"><br><br>

            <input type="submit" value="Salvar Alterações">
            <a href="../pages/perfil.php">Cancelar</a>
        </form>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
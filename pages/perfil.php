<?php
session_start();
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';

// Processa a exclusão da conta do usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir_conta') {
    excluir_conta($conexao, $_SESSION['id_usuario']);
}

// Busca os dados do usuário para preencher a tela
$usuario = buscar_usuario($conexao, $_SESSION['id_usuario']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Travely</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <h1>Meu Perfil</h1>

        <div class="caixa-perfil">
            <div class="foto-perfil">
                <img src="../assets/img/avatar.png" alt="Avatar do usuário" width="100">
            </div>

            <label><strong>Nome:</strong></label><br>
            <input type="text" value="<?= htmlspecialchars($usuario['nome'] ?? ''); ?>" readonly><br><br>

            <label><strong>Email:</strong></label><br>
            <input type="email" value="<?= htmlspecialchars($usuario['email'] ?? ''); ?>" readonly><br><br>

            <label><strong>Senha:</strong></label><br>
            <input type="password" value="********" readonly><br><br>

            <div class="acoes-perfil">
                <!-- Formulário para Excluir Conta com confirmação -->
                <form action="" method="POST" onsubmit="return confirm('Tem certeza de que deseja excluir sua conta? Esta ação apagarar todas as suas viagens e não poderá ser desfeita!');">
                    <input type="hidden" name="acao" value="excluir_conta">
                    <input type="submit" value="Excluir">
                </form>

                <!-- Redireciona direto para a nova página -->
                <a href="../login/atualizar_perfil.php"><button type="button">Atualizar</button></a>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
<?php
// index.php: Tela de entrada do sistema

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travely</title>
    <!-- Importa o arquivo de estilo CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="fundo">

    <!-- Caixa principal no meio da tela -->
    <div class="caixa-principal">
        <h1>Travely</h1>
        
        <!-- Caixa sobre o sistema -->
        <div class="caixa-sobre">
            <h3>Sobre</h3>
            <p>Seja muito bem-vindo(a) ao Travely! <br> Guarde suas memórias de viagens, fotos e relatos em um só lugar.</p>
        </div>

        <!-- Botões para navegar até as páginas de Login e Cadastro -->
        <div class="botoes">
            <a href="login/login.php" class="login">Login</a>
            <a href="login/cadastro.php" class="cadastro">Cadastre-se</a>
        </div>
    </div>

</body>
</html>
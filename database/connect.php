<?php
// connect.php: estabelece a conexão entre o servidor PHP e o banco PostgreSQL

// Define os dados de acesso ao banco de dados
$host = "localhost"; // Endereço do servidor onde o banco está (IP)
$port   = "5432";           // Porta padrão do PostgreSQL
$dbname = "diario_viagens"; // O nome do seu banco de dados
$user = "postgres"; // Nome do usuário do PostgreSQL
$pass = "12345"; // Senha do usuário do PostgreSQL


// Tenta estabelecer a conexão com o banco de dados usando PDO
try {
    $conexao = new PDO(
        // PDO (PHP Data Objects) é uma extensão do PHP utilizada para criar uma conexão segura.
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $pass,
    );
    echo "Conexão realizada com sucesso! <br>";
    // Retorna a conexão para ser utilizada em outros arquivos
    return $conexao;
} catch (PDOException $e) {
    // Caso ocorra algum erro na conexão (senha incorreta, banco fora do ar...), exibe a mensagem de erro.
    echo "Erro: " . $e->getMessage();
}

<?php
require_once __DIR__ . '/../config.php';
try {
    // Se DB_PORT não existir, ele assume a porta 5432 automaticamente
    $port = defined('DB_PORT') ? DB_PORT : '5432';
    $dsn = "pgsql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_NAME;
    $conexao = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erro ao conectar ao PostgreSQL: " . $e->getMessage());
}
?>
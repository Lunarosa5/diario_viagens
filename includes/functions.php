<?php
//functions.php: guarda todas as funções do sistema que serão utilizadas nas páginas


// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../database/connect.php';


// FUNÇÕES DE AUTENTICAÇÃO (LOGIN E CADASTRO DE USUÁRIOS)

// Cadastra um novo usuário no sistema com senha criptografada

function cadastrar_user($conexao, $nome, $email, $senha)
{
    // Criptografa a senha com BCRYPT (ferramenta para criar e verificar hashes de senhas).
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    //  "Prepara" os campos a serem preenchidos com o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";

    // Tenta executar a query e trata possíveis erros
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha_hash);
        // bindParam é usado para vincular os valores aos parâmetros da consulta SQL.

        // Executa a query para inserir o novo usuário no banco de dados
        $stmt->execute();
        echo "<p class='alerta sucesso'>Usuário cadastrado com sucesso!<a href='login.php'>Faça login aqui</a></p>";

    } catch (PDOException $e) {
        // Código 23505 no PostgreSQL indica uma violação de chave única, no caso, que o e-mail já existe (UNIQUE)
        if ($e->getCode() == '23505') {
            echo "<p class='alerta erro'>Este e-mail já está cadastrado no sistema!</p>";
        } else {
            echo "<p class='alerta erro'>Erro ao cadastrar: " . $e->getMessage() . "</p>";
        }
    }
}

// Busca os dados de um usuário pelo e-mail para validar o Login

function consulta_user($conexao, $email)
{
    $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = :email";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        // Retorna o array do usuário ou false se não encontrar
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario;

    } catch (PDOException $e) {
        echo "<p class='alerta erro'>Erro ao buscar usuário: " . $e->getMessage() . "</p>";
    }
}

// =============================================================================
// FUNÇÕES DE GESTÃO DE VIAGENS (CRUD QUE FICARÁ NA PASTA PAGES/)
// =============================================================================

/**
 * Cadastra uma nova viagem vinculada ao ID do usuário logado
 */
function cadastrar_viagem($conexao, $usuario_id, $titulo, $destino, $data_inicio, $data_fim, $descricao, $avaliacao)
{
    $sql = "INSERT INTO viagens (usuario_id, titulo, destino, data_inicio, data_fim, descricao, avaliacao) 
            VALUES (:usuario_id, :titulo, :destino, :data_inicio, :data_fim, :descricao, :avaliacao)";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":destino", $destino);
        $stmt->bindParam(":data_inicio", $data_inicio);
        $stmt->bindParam(":data_fim", $data_fim);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":avaliacao", $avaliacao);

        $stmt->execute();
        echo "<p class='alerta sucesso'>Viagem cadastrada com sucesso!</p>";

    } catch (PDOException $e) {
        echo "<p class='alerta erro'>Erro ao cadastrar viagem: " . $e->getMessage() . "</p>";
    }
}

/**
 * Lista todas as viagens cadastradas do usuário logado
 */
function relatorio_viagens($conexao, $usuario_id)
{
    $sql = "SELECT * FROM viagens WHERE usuario_id = :usuario_id ORDER BY id DESC";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();

        $viagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $viagens;

    } catch (PDOException $e) {
        echo "<p class='alerta erro'>Erro ao buscar viagens: " . $e->getMessage() . "</p>";
    }
}

/**
 * Apaga uma viagem específica confirmando o ID do usuário
 */
function apagar_viagem($conexao, $id, $usuario_id)
{
    $sql = "DELETE FROM viagens WHERE id = :id AND usuario_id = :usuario_id";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();

        echo "<p class='alerta sucesso'>Viagem removida com sucesso!</p>";

    } catch (PDOException $e) {
        echo "<p class='alerta erro'>Erro ao apagar viagem: " . $e->getMessage() . "</p>";
    }
}
?>
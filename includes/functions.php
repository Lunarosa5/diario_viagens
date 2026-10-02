<?php
// functions.php: guarda todas as funções do sistema que serão utilizadas nas páginas


// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../database/connect.php';


// FUNÇÕES PARA LOGIN E CADASTRO DE USUÁRIOS:

// cadastra_user: Cadastra um novo usuário no sistema com senha criptografada

function cadastrar_user($conexao, $nome, $email, $senha)
{
    // Criptografa a senha com BCRYPT (ferramenta para criar e verificar hashes de senhas).
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    //  "Prepara" os campos a serem preenchidos com o novo usuário no banco de dados. Também foi usado o RETURNING id para obter o ID gerado no INSERT

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha) RETURNING id";

    // Tenta executar a query e trata possíveis erros
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha_hash);
        // bindParam é usado para vincular os valores aos parâmetros da consulta SQL.

        // Pega o ID retornado pelo PostgreSQL
        if ($stmt->execute()) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Loga o usuário criando as chaves na SESSÃO
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nome_usuario'] = $nome;

            // Retorna true para indicar que o cadastro foi bem-sucedido
            return true;
        }
        // Se o cadastro falhar, retorna false
        return false;
    } catch (PDOException $e) {
        if ($e->getCode() == '23505') {
            // Código 23505 no PostgreSQL indica uma violação de chave única, no caso, que o e-mail já existe (UNIQUE)

            echo "<p class='alerta erro'>Este e-mail já está cadastrado no sistema!</p>";
        } else {
            echo "<p class='alerta erro'>Erro ao cadastrar: " . $e->getMessage() . "</p>";
        }
        return false;
    }
}

// consulta_user: Busca os dados de um usuário pelo e-mail para validar o login

function consulta_user($conexao, $email)
{
    $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = :email";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        // Retorna o array do usuário se não encontrar as informações
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// dados_dashboard: Função para buscar os dados dos 3 espaços da Dashboard
function dados_dashboard($conexao, $id_usuario)
{
    // Calcula o total de viagens, faz a média das notas e soma a diferença de dias
    $sql = "SELECT 
                COUNT(*) as total_viagens,
                AVG(avaliacao) as media_notas,
                SUM(data_fim - data_inicio + 1) as dias_viagens
            FROM viagens 
            WHERE id_usuario = :id_usuario";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return ['total_viagens' => 0, 'media_notas' => 0, 'dias_viagens' => 0];
    }
}

// Função para buscar as 2 últimas viagens cadastradas pelo usuário
function ultimas_viagens($conexao, $id_usuario)
{
    $sql = "SELECT * FROM viagens 
            WHERE id_usuario = :id_usuario 
            ORDER BY data_inicio DESC 
            LIMIT 2";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}



// FUNÇÕES DE GESTÃO DE VIAGENS (CRUD QUE FICARÁ NA PASTA PAGES)


// cadastrar_viagem: Função para cadastrar uma nova viagem
function cadastrar_viagem($conexao, $id_usuario, $titulo, $destino, $data_inicio, $data_fim, $relato, $avaliacao)
// A função cadastrar_viagem recebe os parâmetros necessários para cadastrar uma nova viagem no banco de dados.
{
    // RETURNING id é necessário no PostgreSQL para capturar o ID da viagem recém-criada
    $sql = "INSERT INTO viagens (id_usuario, titulo, destino, data_inicio, data_fim, relato, avaliacao) 
            VALUES (:id_usuario, :titulo, :destino, :data_inicio, :data_fim, :relato, :avaliacao) RETURNING id";
    
    // A função tenta executar a query, com o try, e trata possíveis erros, com o catch. Se a execução for bem-sucedida, retorna true, caso contrário, retorna false.
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':destino', $destino);
        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->bindParam(':data_fim', $data_fim);
        $stmt->bindParam(':relato', $relato);
        $stmt->bindParam(':avaliacao', $avaliacao);
         
        // Executa a query para inserir a nova viagem no banco de dados. Se a execução for bem-sucedida, retorna o ID da viagem criada, caso contrário, retorna false, mostrando o erro ocorrido.
        if ($stmt->execute()) {
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['id']; // Retorna o ID da viagem criada
        }
        return false;
    } catch (PDOException $e) {
        echo "<p class='alerta erro'>Erro ao cadastrar viagem: " . $e->getMessage() . "</p>";
        return false;
    }
}

// rela
function relatorio($conexao)
{
    $sql = "SELECT * FROM viagens ORDER BY destino DESC";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $viagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($viagens as $viagem) {
            
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}









// FUNÇÕES DE GESTÃO DE VIAGENS (CRUD QUE FICARÁ NA PASTA PAGES/)



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

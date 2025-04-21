<?php
include '../conexao.php'; // Arquivo de conexão com o banco

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando os dados do formulário
    $estudante = $_POST['estudante'] ?? '';
    $aula = $_POST['aula'] ?? '';
    $situacao = $_POST['situacao'] ?? '';
    $turma = $_POST['turma'] ?? '';
    $professor_nome = $_POST['professor_nome'] ?? '';
    $data = $_POST['data'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $encaminhamento = $_POST['encaminhamento'] ?? '';

    // Verificar se os campos estão preenchidos
    if (empty($estudante) || empty($aula) || empty($situacao) || empty($turma) || empty($professor_nome) || empty($data) || empty($descricao)) {
        die("Erro: Todos os campos obrigatórios devem ser preenchidos.");
    }

    try {
        // Buscar o ID do professor pelo nome
        $sql_professor = "SELECT id FROM Professor WHERE nome = ?";
        $stmt_professor = $conn->prepare($sql_professor);
        $stmt_professor->execute([$professor_nome]);

        // Se encontrou o professor
        if ($stmt_professor->rowCount() > 0) {
            $professor_id = $stmt_professor->fetchColumn();

            // Inserir ocorrência com o professor_id
            $sql = "INSERT INTO Ocorrencia (estudante, aula, situacao, turma, professor_id, data, descricao, encaminhamento) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$estudante, $aula, $situacao, $turma, $professor_id, $data, $descricao, $encaminhamento]);

            header("Location: historico.php");
            exit();
        } else {
            echo "Erro: Professor não encontrado!";
        }
    } catch (PDOException $e) {
        echo "Erro ao cadastrar ocorrência: " . $e->getMessage();
    }
}
?>

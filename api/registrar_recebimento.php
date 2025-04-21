<?php
include '../conexao.php';

if (isset($_POST['ocorrencia_id'], $_POST['data_recebimento'], $_POST['responsavel'])) {
    $ocorrencia_id = $_POST['ocorrencia_id'];
    $data_recebimento = $_POST['data_recebimento'];
    $responsavel = $_POST['responsavel'];

    try {
        // Iniciar transação
        $conn->beginTransaction();

        // Registrar o recebimento na tabela Coordenacao
        $stmt = $conn->prepare("INSERT INTO Coordenacao (ocorrencia_id, data_recebimento, responsavel_recebimento) VALUES (?, ?, ?)");
        $stmt->execute([$ocorrencia_id, $data_recebimento, $responsavel]);

        // Atualizar o status da ocorrência para "Concluído"
        $update_stmt = $conn->prepare("UPDATE Ocorrencia SET status = 'Concluído' WHERE id = ?");
        $update_stmt->execute([$ocorrencia_id]);

        // Confirmar transação
        $conn->commit();

        header("Location: coordenacao.php");
        exit();
    } catch (PDOException $e) {
        // Reverter em caso de erro
        $conn->rollBack();
        echo "Erro ao registrar o recebimento: " . $e->getMessage();
    }
} else {
    echo "Erro: Todos os campos são obrigatórios.";
}
?>

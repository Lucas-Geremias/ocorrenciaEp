<?php
include __DIR__ . '/conexao.php'; // Conexão com o banco de dados
// Esse arquivo deve criar a conexão PDO e armazenar em $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = password_hash($_POST['senha'] ?? '', PASSWORD_DEFAULT);
    $admin = 1;

    if (empty($nome) || empty($email) || empty($_POST['senha'])) {
        echo "Todos os campos são obrigatórios!";
        exit();
    }

    try {
        // Verificar se o email já está cadastrado
        $query = "SELECT id FROM Coordenador WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo "Este email já está cadastrado!";
        } else {
            // Inserir novo coordenador
            $query = "INSERT INTO Coordenador (nome, email, senha, admin) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$nome, $email, $senha, $admin]);

            echo "Cadastro realizado com sucesso!";
            header("Location: /ocorrenciamain/public/geral.html");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

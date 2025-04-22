<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $disciplina = $_POST['disciplina'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Sempre criptografe

    $sql = "INSERT INTO Professor (nome, email_institucional, cpf, disciplina, senha) 
            VALUES (:nome, :email, :cpf, :disciplina, :senha)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':cpf' => $cpf,
            ':disciplina' => $disciplina,
            ':senha' => $senha
        ]);

        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='/ocorrenciamain/login_professor.html';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao cadastrar: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>

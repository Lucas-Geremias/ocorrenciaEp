<?php
session_start();
include '../conexao.php'; // Conexão com PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara e executa a consulta
    $sql = "SELECT id, nome, senha FROM Professor WHERE email_institucional = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Verifica se encontrou o usuário
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica a senha
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['id_professor'] = $row['id'];
            $_SESSION['nome_professor'] = $row['nome'];
            header("Location: historico_professor.php");
            exit();
        } else {
            echo "<script>alert('Senha incorreta!'); window.location.href='/ocorrenciamain/public/login_professor.html';</script>";
        }
    } else {
        echo "<script>alert('E-mail não encontrado!'); window.location.href='/ocorrenciamain/public/login_professor.html';</script>";
    }
}
?>

<?php
// Conectar ao banco de dados com PDO
$host = "localhost";
$dbname = "ocorrencias";
$username = "root";
$password = "";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password); // Troque para "mysql:" se ainda estiver em MySQL
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Verifica se os campos do formulário foram preenchidos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? '';
    $email = $_POST["email"] ?? '';
    $cpf = $_POST["cpf"] ?? '';
    $disciplinasContainer = $_POST["disciplina"] ?? '';
    $senha = $_POST["senha"] ?? '';

    if (empty($nome) || empty($email) || empty($cpf) || empty($disciplinasContainer) || empty($senha)) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    try {
        // Verificar se o email já existe
        $sql_verifica = "SELECT id FROM professor WHERE email_institucional = ?";
        $stmt_verifica = $conn->prepare($sql_verifica);
        $stmt_verifica->execute([$email]);

        if ($stmt_verifica->rowCount() > 0) {
            die("Erro: Este email já está cadastrado.");
        }

        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir no banco
        $sql = "INSERT INTO professor (nome, email_institucional, cpf, disciplina, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $email, $cpf, $disciplinasContainer, $senha_hash]);

        echo "Cadastro realizado com sucesso!";
        header("Location: /ocorrenciamain/public/geral.html");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

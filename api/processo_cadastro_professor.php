<?php
session_start(); // Inicia a sessão para uso do CSRF e variáveis globais
include __DIR__ . '/conexao.php'; // Conexão com o banco de dados

// Conectar ao banco de dados com variáveis de ambiente
$host = getenv("DB_HOST");
$port = getenv("DB_PORT");
$dbname = getenv("DB_NAME");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Segurança extra para evitar injeção SQL
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Gerar token CSRF para segurança do formulário
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Verifica se os campos do formulário foram preenchidos e se o método é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? '';
    $email = $_POST["email"] ?? '';
    $cpf = $_POST["cpf"] ?? '';
    $disciplinasContainer = $_POST["disciplina"] ?? '';
    $senha = $_POST["senha"] ?? '';
    $csrfToken = $_POST["csrf_token"] ?? '';

    // Validações básicas
    if (empty($nome) || empty($email) || empty($cpf) || empty($disciplinasContainer) || empty($senha)) {
        die("Erro: Todos os campos são obrigatórios.");
    }

    // Validação do token CSRF
    if ($csrfToken !== $_SESSION['csrf_token']) {
        die("Erro: CSRF token inválido.");
    }

    // Validação do formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erro: Email inválido.");
    }

    try {
        // Verificar se o email já existe no banco
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

        // Redirecionar após sucesso
        header("Location: /ocorrenciamain/public/geral.html");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professor</title>
    <link rel="stylesheet" href="/ocorrenciamain/public/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Cadastro de Professor</h2>
        <?php if (isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            
            <label>Nome:</label>
            <input type="text" name="nome" placeholder="Digite seu nome" required />

            <label>Email:</label>
            <input type="email" name="email" placeholder="Digite seu e-mail institucional" required />

            <label>CPF:</label>
            <input type="text" name="cpf" placeholder="Digite seu CPF" required />

            <label>Disciplina:</label>
            <input type="text" name="disciplina" placeholder="Digite a(s) disciplina(s)" required />

            <label>Senha:</label>
            <input type="password" name="senha" placeholder="Digite sua senha" required />

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>

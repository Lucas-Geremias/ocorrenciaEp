<?php
session_start();
include __DIR__ . '/conexao.php'; // Inclua seu arquivo de conexão PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    try {
        // Consulta para verificar se o usuário está na coordenação
        $query = "SELECT id, nome, senha FROM Coordenador WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifica a senha
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['coordenacao_id'] = $user['id'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['admin'] = true; // Define como admin
                header("Location: geral.html"); // Redireciona para a área administrativa
                exit();
            } else {
                $erro = "Email ou senha inválidos!";
            }
        } else {
            $erro = "Email ou senha inválidos!";
        }
    } catch (PDOException $e) {
        $erro = "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login da Coordenação</title>
    <link rel="stylesheet" href="/ocorrenciamain/public/login.css">
</head>
<body>
    
    <div class="login-container">
        <h2>Login da Coordenação</h2>
        <?php if (isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
        <form action="" method="POST">
            <label>Email:</label>
            <input
                type="email"
                name="email"
                placeholder="Digite seu e-mail"
                required
            />
    
            <label>Senha:</label>
            <input
                type="password"
                name="senha"
                placeholder="Digite sua senha"
                required
            />
            <button type="submit" >Entrar</button>
        </form>
    </div>
</body>
</html>

<?php
include 'conexao.php'; // Conexão com o banco de dados

// Verifica se a conexão foi bem-sucedida
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Consulta para buscar todos os professores
$query = "SELECT id, nome, email_institucional, cpf, disciplina FROM Professor";
$result = $conn->query($query);

// Verifica se a consulta foi bem-sucedida
if (!$result) {
    die("Erro ao recuperar dados: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Professores</title>
    <link rel="stylesheet" href="/ocorrenciamain/public/listar.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="/ocorrenciamain/img/brasao-do-ceara.png" alt="Brasão do Ceará" width="70px" />
            <p class="texto" style="color: white">
                GOVERNO DO ESTADO DO CEARÁ <br />
                19ª COORDENADORIA REGIONAL DE DESENVOLVIMENTO DA EDUCAÇÃO <br />
                ESCOLA ESTADUAL DE EDUCAÇÃO PROFISSIONAL PAULO BARBOSA LEITE
            </p>
            <img src="/ocorrenciamain/img/escola-removebg-preview.png" alt="Logo da Escola" width="100px" />
        </div>
    </header>

    <div class="container">
        <a href="/ocorrenciamain/public/geral.html" class="btn btn-warning btn-xs">
            <button>Voltar</button>
        </a>
        <h1>Lista de Professores</h1>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email Institucional</th>
                    <th>CPF</th>
                    <th>Disciplina</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['email_institucional'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['cpf'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['disciplina'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="editar_professor.php?id=<?php echo $row['id']; ?>" class="button edit-button">Editar</a>
                            <a href="excluir_professor.php?id=<?php echo $row['id']; ?>" class="button delete-button" onclick="return confirm('Tem certeza que deseja excluir este professor?')">Excluir</a>
                        </td>
                    </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='5'>Nenhum professor encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

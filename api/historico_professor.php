<?php
include __DIR__ . '/conexao.php';

try {
    // Verifica se a coluna 'status' existe
    $verifica_coluna = "SHOW COLUMNS FROM Ocorrencia LIKE 'status'";
    $stmt = $conn->query($verifica_coluna);

    if ($stmt->rowCount() === 0) {
        // Adiciona a coluna se não existir
        $alter_sql = "ALTER TABLE Ocorrencia ADD COLUMN status ENUM('pendente', 'andamento', 'concluido') NOT NULL DEFAULT 'pendente'";
        $conn->exec($alter_sql);
    }

    // Consulta de dados com JOIN
    $sql = "SELECT Ocorrencia.id, Ocorrencia.estudante, Ocorrencia.situacao, Ocorrencia.data, 
                   Professor.nome AS professor, Ocorrencia.status 
            FROM Ocorrencia 
            JOIN Professor ON Ocorrencia.professor_id = Professor.id";

    $stmt = $conn->query($sql);
    $ocorrencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Ocorrências</title>
    <link rel="stylesheet" href="/ocorrenciamain/public/historico.css">
</head>
<body>

<header>
    <div class="logo-container">
        <img src="/ocorrenciamain/img/brasao-do-ceara.png" alt="Brasão do Ceará" width="70px">
        <p class="texto" style="color: white">
            GOVERNO DO ESTADO DO CEARÁ <br>
            19ª COORDENADORIA REGIONAL DE DESENVOLVIMENTO DA EDUCAÇÃO <br>
            ESCOLA ESTADUAL DE EDUCAÇÃO PROFISSIONAL PAULO BARBOSA LEITE
        </p>
        <img src="/ocorrenciamain/img/escola-removebg-preview.png" alt="Logo da Escola" width="100px">
    </div>
</header>

<main>
    <div class="tudo">
        <div class="h1-novo">
            <div class="h1-busca">
                <button type="button" id="concluido" class="btn btn-success btn-xs">Concluído</button>
                <button type="button" id="pendente" class="btn btn-warning btn-xs">Pendente</button>
                <button type="button" class="btn btn-xs">Todos</button>
                <div class="btn-group">
                    <a href="/ocorrenciamain/public/TelaOcorrencia2.html" class="btn btn-warning btn-xs">
                        <button>Nova Ocorrência</button>
                    </a>
                </div>

                <div id="divBusca">
                    <input type="text" id="txtBusca" placeholder="Buscar...">
                    <img src="/ocorrenciamain/img/lupa.png" id="btnBusca" alt="Buscar" width="20px">
                </div>
            </div>
        </div>

        <div class="main-container">
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Problema</th>
                            <th>Data</th>
                            <th>Professor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ocorrencias as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['estudante']); ?></td>
                            <td><?php echo htmlspecialchars($row['situacao']); ?></td>
                            <td><?php echo date("d/m/Y", strtotime($row['data'])); ?></td>
                            <td><?php echo htmlspecialchars($row['professor']); ?></td>
                            <td data-estado="<?php echo htmlspecialchars($row['status']); ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="/ocorrenciamain/historicoscript.js"></script>

</body>
</html>

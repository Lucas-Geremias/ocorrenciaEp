<?php
$host = "seu-banco-de-dados.render.com";  // Substitua pelo host do banco de dados fornecido pelo Render
$usuario = "seu-usuario";                 // Usuário do banco de dados fornecido pelo Render
$senha = "sua-senha";                     // Senha do banco de dados fornecida pelo Render
$banco = "ocorrencias";                   // Nome do banco de dados

// Criar conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>

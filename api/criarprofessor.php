<?php
require '../config/conexao.php';
require '../classes/Professor.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['nome'], $data['email'], $data['senha'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Dados incompletos']);
    exit;
}

$prof = new Professor($pdo);
if ($prof->criar($data['nome'], $data['email'], $data['senha'])) {
    echo json_encode(['mensagem' => 'Professor criado com sucesso!']);
} else {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao criar professor']);
}

<?php
$host = "dpg-d02kpdidbo4c73eufbt0-a"; // Hostname que tu pegou na Render
$port = "5432";
$dbname = "ocorrencias";
$user = "ocorrencias_user";
$pass = "SUA_SENHA_AQUI"; // substitui por tua senha real

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
<?php
require_once __DIR__ . '/vendor/autoload.php';  // Carrega o autoload do Composer

use Dotenv\Dotenv;

// Carrega o arquivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Agora você pode usar as variáveis de ambiente
$host = getenv("DB_HOST");
$port = getenv("DB_PORT");
$dbname = getenv("DB_NAME");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");

// Verifica se todas as variáveis estão carregadas
if (!$host || !$port || !$dbname || !$user || !$pass) {
    die("Erro: Uma ou mais variáveis de ambiente não estão definidas.");
}

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

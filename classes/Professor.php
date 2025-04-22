<?php
class Professor {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function criar($nome, $email, $senha) {
        $stmt = $this->conn->prepare("INSERT INTO professores (nome, email, senha) VALUES (:nome, :email, :senha)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', password_hash($senha, PASSWORD_BCRYPT));
        return $stmt->execute();
    }
}

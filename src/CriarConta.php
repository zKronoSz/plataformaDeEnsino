<?php
namespace Src;

use PDO;

class CriarConta
{
    private $pdo;

    public function __construct(ConexaoBD $conexao)
    {
        $this->pdo = $conexao->conectar();
    }

    public function cadastrar(string $nome, string $email, string $senha): bool
    {
        $query = "SELECT id FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->fetch()) {
            return false;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $insert = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->pdo->prepare($insert);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senhaHash);

        return $stmt->execute();
    }
}
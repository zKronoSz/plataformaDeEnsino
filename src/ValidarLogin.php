<?php
namespace Src;

use PDO;

class ValidarLogin
{
    private $pdo;

    public function __construct(ConexaoBD $conexao)
    {
        $this->pdo = $conexao->conectar();
    }

    public function autenticar(string $email, string $senha): bool
    {
        $query = "SELECT senha FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return true;
        }

        return false;
    }
}
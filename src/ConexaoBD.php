<?php
namespace Src;

use PDO;
use PDOException;

class ConexaoBD
{
    public function conectar(): PDO
    {
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        try {
            return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }
}
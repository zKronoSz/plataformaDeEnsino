<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

use Src\ConexaoBD;
use Src\CriarConta;
use Src\ValidarLogin;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    $conexao = new ConexaoBD();

    if ($acao === 'cadastrar') {
        // Corrigir para os nomes corretos do POST
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if ($nome && $email && $senha) {
            $criarConta = new CriarConta($conexao);
            if ($criarConta->cadastrar($nome, $email, $senha)) {
                header('Location: form.html');
                exit;
            } else {
                $_SESSION['erro'] = "E-mail já cadastrado.";
            }
        } else {
            $_SESSION['erro'] = "Preencha todos os campos.";
        }

    } elseif ($acao === 'login') {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if ($email && $senha) {
            $validador = new ValidarLogin($conexao);
            if ($validador->autenticar($email, $senha)) {
                header('Location: videos.html');
                exit;
            } else {
                $_SESSION['erro'] = "E-mail ou senha inválidos.";
            }
        } else {
            $_SESSION['erro'] = "Preencha todos os campos.";
        }

    } else {
        $_SESSION['erro'] = "Ação inválida.";
    }
}

if (!empty($_SESSION['erro'])) {
    echo '<p style="color:red;">' . htmlspecialchars($_SESSION['erro']) . '</p>';
    unset($_SESSION['erro']);
}
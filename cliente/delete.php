<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login/login.php');
    exit();
}

// Conexão com o banco de dados
$host = 'localhost';
$db = 'odontologia';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Obtenha o ID do usuário atualmente logado
$usuario_id = $_SESSION['usuario_id'];

// Exclua a conta do usuário do banco de dados
$stmt = $pdo->prepare('DELETE FROM usuarios WHERE id = ?');
$stmt->execute([$usuario_id]);

// Redirecione para a página de login após excluir a conta
header('Location: ../login/login.php?exclusao_sucesso=true');
exit();
?>

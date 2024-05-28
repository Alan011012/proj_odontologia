<?php
if (isset($_POST['submit'])) {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
    if (!empty($nome)&&!empty($email) && !empty($senha)) {
        session_start();
        require 'conexao.php';

        $sql = "SELECT id, dentista FROM usuarios WHERE nome = :nome AND email = :email AND senha = :senha";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['usuario_id'] = $usuario['id'];

            $dentista = $usuario['dentista'];

            if ($dentista == 1) {
                header('Location: ../dentista/index.php');
                exit();
            } else {
              header('Location: ../cliente/index.php');
              exit();
            }
        } else {
            $erro = "Email ou senha incorretos.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }

    if (isset($erro)) {
        $_SESSION['erro_login'] = $erro;
        header('Location: ../login/login.php');
        exit();
    }
}
?>
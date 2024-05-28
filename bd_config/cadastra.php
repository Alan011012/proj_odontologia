<?php
    if(isset($_POST['submit'])){
        if(isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['senha']) && !empty($_POST['senha'])){
            session_start();
            require 'conexao.php';
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $stmt = $conn->prepare('SELECT COUNT(*) FROM usuarios WHERE email = :email');
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                header("Location: ../login/login.php?email=existe");
            } else{
            $sql = "INSERT INTO usuarios(nome, email, senha) VALUES(:nome,:email,:senha)";
            $resultado = $conn->prepare($sql);
            $resultado->bindValue("nome", $nome);
            $resultado->bindValue("email", $email);
            $resultado->bindValue("senha", $senha);
            $resultado->execute();
            header('Location: ../login/login.php?success=ok');
            $_SESSION['cadastro_sucesso'] = true;
        }
    }
}
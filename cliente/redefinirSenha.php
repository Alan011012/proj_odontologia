<?php
// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os valores do formulário
    $senhaAtual = $_POST["currentPassword"];
    $novaSenha = $_POST["newPassword"];
    $confirmacaoSenha = $_POST["confirmPassword"];

    // Verifica se a nova senha e a confirmação são iguais
    if ($novaSenha != $confirmacaoSenha) {
      header('Location: index.php?confirmacao=true');      
        exit; // Encerra o script
    }

    // Aqui você precisa adicionar a lógica para verificar a senha atual no banco de dados
    // e atualizar a senha se estiver correta

    // Inicie ou recupere a sessão para acessar os dados do usuário logado
    session_start();

    // Verifica se o usuário está logado
    if (!isset($_SESSION["usuario_id"])) {
        echo "<script>alert('Erro: Usuário não logado');</script>";
        exit; // Encerra o script se o usuário não estiver logado
    }

    // Obtém o ID do usuário logado a partir da sessão
    $usuario_id = $_SESSION["usuario_id"];

    // Conexão com o banco de dados (substitua as credenciais conforme necessário)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "odontologia";

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Consulta para obter a senha atual do usuário
    $sql = "SELECT senha FROM usuarios WHERE id = $usuario_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $senhaBanco = $row["senha"];
        // Verifica se a senha atual digitada corresponde à senha no banco de dados
        if ($senhaAtual != $senhaBanco) {
          header('Location: index.php?senha_errada=true');
        } else {
            // Atualiza a senha no banco de dados
            $updateSql = "UPDATE usuarios SET senha = '$novaSenha' WHERE id = $usuario_id";
            if ($conn->query($updateSql) === TRUE) {
              header('Location: index.php?redefinida=true');
            } else {
              header('Location: index.php?erro=true');
            }
        }
    } else {
        echo "<script>alert('Erro: Usuário não encontrado');</script>";
    }

    // Fecha a conexão
    $conn->close();
}
?>


<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('location: ../login/login.php');
    exit();
}


require"../bd_config/conexao.php";
// Função para obter o nome do usuário logado
function getLoggedInUser($conn) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare('SELECT nome FROM usuarios WHERE id = ?');
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    return $usuario ? $usuario['nome'] : 'Usuário';   
}
$usuario = getLoggedInUser($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>DentalMaster</title>
    <style>
        /* Seu estilo CSS aqui */
        .sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
            transition: width 0.5s; /* Adicionando transição para animação suave */
        }

        .logout-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Alinhar itens à esquerda */
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        .user-info {
            margin-bottom: 10px; /* Adicionando margem inferior para separar o nome do usuário do botão */
        }
        
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <div>
                <div class="sidebar-logo">
                    <a href="#">DentalMaster</a>
                </div>
                <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Painel
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Seja Bem Vindo
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="marcaConsulta.php" class="sidebar-link collapsed" 
                            aria-expanded="false" aria-controls="pages">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                            Marca consulta
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" 
                            aria-expanded="false" aria-controls="dashboard" id="updatePasswordLink">
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Atualizar senha
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" 
                            aria-expanded="false" aria-controls="auth" id="deleteAccountLink">
                            <i class="fa-regular fa-user pe-2"></i>
                            Deletar Conta
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Nome do usuário e botão de sair -->
            <div class="logout-section">
                <div class="user-info">
                    <strong><?php echo htmlspecialchars($usuario); ?></strong>
                </div>
                <!-- Botão de sair -->
                <button id="logoutButton" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">Sair</button>
            </div>
        </aside>
        <!-- Main Component -->
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <!-- Button for sidebar toggle -->
                <button class="btn" type="button" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h1>Seja Bem Vindo</h1>
                        <!-- Mensagens de feedback -->
                        <?php
                        if (isset($_GET['redefinida']) && $_GET['redefinida'] === 'true') {
                            echo '<div style="color: green;"><strong>Senha Atualizada!</strong></div>';
                        }
                        if (isset($_GET['erro']) && $_GET['erro'] === 'true') {
                            echo '<div style="color: red;"><strong>Erro ao atualizar senha</strong></div>';
                        }
                        if (isset($_GET['senha_errada']) && $_GET['senha_errada'] === 'true') {
                            echo '<div style="color: red;"><strong>Senha atual incorreta</strong></div>';
                        }
                        if (isset($_GET['confirmacao']) && $_GET['confirmacao'] === 'true') {
                            echo '<div style="color: red;"><strong>Nova senha diferente da senha de confirmação</strong></div>';
                        }
                        ?>
                        <!-- Texto de boas-vindas -->
                        <p>
                            Bem-vindo à família OdontoMaster!
                            Temos o prazer de recebê-lo em nosso querido consultório odontológico! Como parte importante da nossa equipe, você está prestes a embarcar em uma jornada emocionante.
                        </p>
                        <p>
                            Neste espaço dedicado à saúde oral, cada sorriso tem um significado único e, através do seu talento e dedicação, continuamos a mudar vidas, um sorriso de cada vez. Quer você seja um profissional experiente ou um novato ansioso por deixar sua marca, saiba que sua presença aqui é valorizada e celebrada.
                        </p>
                        <p>
                            Nosso compromisso com a excelência é tão forte quanto a base que construímos para reparar e cuidar dos dentes todos os dias. Estamos empenhados em proporcionar um ambiente acolhedor e profissional onde o respeito mútuo, a colaboração e a inovação sejam a base de tudo o que fazemos.
                        </p>
                        <p>
                            Juntos, continuaremos a fazer deste consultório um lugar onde os sorrisos brilham mais, a saúde bucal é uma prioridade e cada paciente recebe respeito, compaixão e cuidado incomparável.
                        </p>
                    </div>
                    <!-- Cards Section -->
                </div>
            </main>
        </div>
    </div>

    <!-- Modal de Confirmação de Sair -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja sair da sua conta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="../bd_config/logout.php" method="post">
                        <button type="submit" class="btn btn-danger">Sair</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Atualização de Senha -->
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordModalLabel">Atualizar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="redefinirSenha.php" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Senha Atual<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Digite a senha atual" required>
                            <div class="invalid-feedback">
                                Por favor, digite sua senha atual.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nova Senha<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Digite a nova senha" required>
                            <div class="invalid-feedback">
                                Por favor, digite sua nova senha.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar Nova Senha<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirme a nova senha" required>
                            <div class="invalid-feedback">
                                Por favor, confirme sua nova senha.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar Senha</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Exclusão de Conta -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirmar Exclusão de Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que deseja excluir esta conta?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="delete.php" class="btn btn-danger">Sim, Excluir</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
        // Adicione um evento de clique ao link "Atualizar senha" na barra lateral
        document.getElementById('updatePasswordLink').addEventListener('click', function () {
            // Exiba o modal de atualizar senha
            var updatePasswordModal = new bootstrap.Modal(document.getElementById('updatePasswordModal'), {});
            updatePasswordModal.show();
        });

        // Adicione um evento de clique ao link "Deletar Conta" na barra lateral
        document.getElementById('deleteAccountLink').addEventListener('click', function () {
            // Exiba o modal de exclusão de conta
            var deleteAccountModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'), {});
            deleteAccountModal.show();
        });
        document.addEventListener('DOMContentLoaded', function() {
    // Adiciona um evento de clique ao elemento body
    document.body.addEventListener('click', function(event) {
        // Verifica se o clique ocorreu dentro do modal ou em um elemento filho do modal
        if (!event.target.closest('.modal-dialog')) {
            // Se o clique não ocorreu dentro do modal, fecha o modal
            var modais = document.querySelectorAll('.modal');
            modais.forEach(function(modal) {
                var bootstrapModal = bootstrap.Modal.getInstance(modal);
                if (bootstrapModal._isShown) {
                    bootstrapModal.hide();
                }
            });
        }
    });
});

    </script>
</body>

</html>
